<?php

namespace App\Controllers;

use App\Models\MessagesThreadModel;
use App\Models\MessagesRecipientModel;

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
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        $recipients = new MessagesRecipientModel();
        $threads = new MessagesThreadModel();

        // Find all threads the user is a recipient of
        $userThreads = $recipients->where('user_id', $userId)->findAll();

        $threadIds = array_map(fn($t) => $t->thread_id, $userThreads);

        $data = [
            'threads' => [],
        ];

        if (!empty($threadIds)) {
            // TODO: This is a simplified version. A real implementation would
            // also fetch the other user in the thread and the last message.
            $data['threads'] = $threads->whereIn('id', $threadIds)->findAll();
        }

        return view('messages/index', $data);
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
        $recipients = new \App\Models\MessagesRecipientModel();
        $isRecipient = $recipients->where('thread_id', $threadId)->where('user_id', $userId)->first();
        if ($isRecipient === null) {
            return redirect()->to('/messages')->with('error', 'You are not authorized to view this message thread.');
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

        return view('messages/show', $data);
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

        return view('messages/new', ['connections' => $friends]);
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

        // TODO: Security check to ensure recipient is a connection.

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
