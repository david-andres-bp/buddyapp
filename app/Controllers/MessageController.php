<?php

namespace App\Controllers;

use App\Models\MessagesThreadModel;
use App\Models\MessagesRecipientModel;
use App\Models\MessageModel;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Database\RawSql;

class MessageController extends BaseController
{
    /**
     * Display a list of the user's message threads.
     */
    public function index()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');
        $userId = auth()->id();
        if (!$userId) { return redirect()->to('/account/login'); }

        $recipientsModel = new MessagesRecipientModel();
        $threadsModel = new MessagesThreadModel();
        $messagesModel = new MessageModel();
        $usersModel = new UserModel();

        // Get all thread recipient data for the user
        $userThreads = $recipientsModel->where('user_id', $userId)->findAll();
        $userThreadIds = array_map(fn($t) => $t->thread_id, $userThreads);
        $isReadMap = array_column($userThreads, 'is_read', 'thread_id');

        if (empty($userThreadIds)) {
            return $this->renderThemeView('messages/index', ['threads' => []]);
        }

        // Get all thread data
        $threads = $threadsModel->whereIn('id', $userThreadIds)->findAll();
        $threadMap = array_column($threads, null, 'id');

        // Get the last message for each thread
        $db = db_connect();
        $subquery = $db->table('messages')->selectMax('id')->whereIn('thread_id', $userThreadIds)->groupBy('thread_id')->getCompiledSelect();
        $lastMessages = $messagesModel->whereIn('id', new RawSql($subquery))->findAll();

        // Get all recipients for these threads to find the other users
        $allRecipients = $recipientsModel->whereIn('thread_id', $userThreadIds)->findAll();
        $otherUserIds = [];
        $threadRecipientsMap = [];
        foreach($allRecipients as $recipient) {
            if ($recipient->user_id !== $userId) {
                $otherUserIds[] = $recipient->user_id;
                $threadRecipientsMap[$recipient->thread_id] = $recipient->user_id;
            }
        }

        // Get user data for all senders and recipients
        $senderIds = array_map(fn($m) => $m->sender_id, $lastMessages);
        $allUserIds = array_unique(array_merge($senderIds, $otherUserIds));
        $userMap = [];
        if (!empty($allUserIds)) {
            $allUsers = $usersModel->whereIn('id', $allUserIds)->findAll();
            $userMap = array_column($allUsers, null, 'id');
        }

        // Combine all data
        foreach ($lastMessages as $message) {
            $threadId = $message->thread_id;
            if (isset($threadMap[$threadId])) {
                $threadMap[$threadId]->last_message = $message;
                $threadMap[$threadId]->last_message->sender = $userMap[$message->sender_id] ?? null;
                $otherUserId = $threadRecipientsMap[$threadId] ?? null;
                if ($otherUserId) {
                    $threadMap[$threadId]->other_user = $userMap[$otherUserId] ?? null;
                }
                $threadMap[$threadId]->is_read = $isReadMap[$threadId] ?? 1;
            }
        }

        // Remove threads where we couldn't find a last message (should be rare)
        $threadMap = array_filter($threadMap, fn($t) => isset($t->last_message));

        // Sort threads by last message time
        usort($threadMap, function($a, $b) {
            $timeA = $a->last_message ? strtotime($a->last_message->created_at) : 0;
            $timeB = $b->last_message ? strtotime($b->last_message->created_at) : 0;
            return $timeB <=> $timeA;
        });

        return $this->renderThemeView('messages/index', ['threads' => $threadMap]);
    }

    /**
     * Display a single message thread.
     */
    public function show(int $threadId)
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        // Security check: ensure user is a recipient of this thread
        $recipientsModel = new \App\Models\MessagesRecipientModel();
        $isRecipient = $recipientsModel->where('thread_id', $threadId)->where('user_id', $userId)->first();
        if ($isRecipient === null) {
            return redirect()->to('/messages')->with('error', 'You are not authorized to view this message thread.');
        }

        // Mark the thread as read for the current user
        if ((int)$isRecipient->is_read === 0) {
            $recipientsModel->update($isRecipient->id, ['is_read' => 1]);
        }

        $threads = new \App\Models\MessagesThreadModel();
        $messages = new \App\Models\MessageModel();
        $users = new \CodeIgniter\Shield\Models\UserModel();

        $thread = $threads->find($threadId);
        $threadMessages = $messages->where('thread_id', $threadId)->orderBy('created_at', 'ASC')->findAll();

        // Get user info for each message
        if (!empty($threadMessages)) {
            $senderIds = array_map(fn($m) => $m->sender_id, $threadMessages);
            $senders = $users->whereIn('id', array_unique($senderIds))->findAll();
            $senderMap = array_column($senders, null, 'id');

            foreach($threadMessages as $message) {
                $message->sender = $senderMap[$message->sender_id] ?? null;
            }
        }

        $data = [
            'thread'   => $thread,
            'messages' => array_filter($threadMessages, fn($m) => $m->sender !== null),
        ];

        return $this->renderThemeView('messages/show', $data);
    }

    /**
     * Handle a reply to a message thread.
     */
    public function reply(int $threadId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        // Security check: ensure user is a recipient of this thread
        $recipients = new \App\Models\MessagesRecipientModel();
        $isRecipient = $recipients->where('thread_id', $threadId)->where('user_id', $userId)->first();
        if ($isRecipient === null) {
            return redirect()->to('/messages')->with('error', 'You are not authorized to reply to this message thread.');
        }

        // Validate the message
        $messageText = $this->request->getPost('message');
        if (empty($messageText)) {
            return redirect()->back()->with('error', 'Message cannot be empty.');
        }

        // Save the new message
        $messages = new \App\Models\MessageModel();
        $data = [
            'thread_id' => $threadId,
            'sender_id' => $userId,
            'message'   => esc($messageText),
        ];

        if ($messages->insert($data) === false) {
            return redirect()->back()->with('error', 'Could not send the message.');
        }

        // TODO: Mark thread as unread for other recipients

        return redirect()->to('/messages/' . $threadId)->with('message', 'Reply sent!');
    }

    /**
     * Show the form for creating a new message thread.
     */
    public function new()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        // Get user's connections to populate the recipient list
        $connections = new \App\Models\ConnectionModel();
        $users = new \CodeIgniter\Shield\Models\UserModel();

        $currentConnections = $connections
            ->groupStart()
                ->where('initiator_user_id', $userId)
                ->orWhere('friend_user_id', $userId)
            ->groupEnd()
            ->where('status', 'accepted')
            ->findAll();

        $friends = [];
        if (!empty($currentConnections)) {
            $friendIds = [];
            foreach($currentConnections as $conn) {
                $friendIds[] = ($conn->initiator_user_id == $userId) ? $conn->friend_user_id : $conn->initiator_user_id;
            }
            $friends = $users->whereIn('id', $friendIds)->findAll();
        }

        return $this->renderThemeView('messages/new', ['connections' => $friends]);
    }

    /**
     * Process the creation of a new message thread.
     */
    public function create()
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        // Validate the form data
        $rules = [
            'recipient' => 'required|integer',
            'subject'   => 'required|max_length[255]',
            'message'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recipientId = $this->request->getPost('recipient');
        $subject = $this->request->getPost('subject');
        $messageText = $this->request->getPost('message');

        // Security check to ensure recipient is a connection.
        $connections = new \App\Models\ConnectionModel();
        $existing = $connections
            ->groupStart()
                ->where('initiator_user_id', $userId)
                ->where('friend_user_id', $recipientId)
            ->groupEnd()
            ->orGroupStart()
                ->where('initiator_user_id', $recipientId)
                ->where('friend_user_id', $userId)
            ->groupEnd()
            ->where('status', 'accepted')
            ->first();

        if ($existing === null) {
            return redirect()->back()->with('error', 'You can only send messages to your connections.');
        }

        // Create a new thread
        $threads = new \App\Models\MessagesThreadModel();
        $threadId = $threads->insert(['subject' => esc($subject)]);

        if ($threadId === false) {
            return redirect()->back()->with('error', 'Could not create the message thread.');
        }

        // Add recipients to the thread
        $recipients = new \App\Models\MessagesRecipientModel();
        $recipients->insert(['thread_id' => $threadId, 'user_id' => $userId]);
        $recipients->insert(['thread_id' => $threadId, 'user_id' => $recipientId]);

        // Add the first message
        $messages = new \App\Models\MessageModel();
        $messages->insert([
            'thread_id' => $threadId,
            'sender_id' => $userId,
            'message'   => esc($messageText),
        ]);

        return redirect()->to('/messages/' . $threadId)->with('message', 'Message sent!');
    }
}
