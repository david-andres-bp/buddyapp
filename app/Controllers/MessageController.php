<?php

namespace App\Controllers;

use App\Models\MessagesThreadModel;
use App\Models\MessagesRecipientModel;
use App\Models\MessageModel;
use CodeIgniter\Shield\Models\UserModel;

class MessageController extends BaseController
{
    /**
     * Display a list of the user's message threads.
     */
    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/account/login');
        }

        $userId = auth()->id();
        $recipients = new MessagesRecipientModel();
        $threads = new MessagesThreadModel();
        $users = new UserModel();

        // Find all threads the user is a recipient of
        $userThreads = $recipients->where('user_id', $userId)->findAll();
        $threadIds = array_map(fn($t) => $t->thread_id, $userThreads);

        $data = ['threads' => []];

        if (!empty($threadIds)) {
            $data['threads'] = $threads->whereIn('id', $threadIds)->findAll();

            foreach ($data['threads'] as &$thread) {
                // Get participants
                $participants = $recipients->where('thread_id', $thread->id)->findAll();
                $participantIds = array_column($participants, 'user_id');
                $otherParticipantIds = array_diff($participantIds, [$userId]);
                $thread->participants = $users->whereIn('id', $otherParticipantIds)->findAll();

                // Get last message
                $messageModel = new MessageModel();
                $thread->last_message = $messageModel->where('thread_id', $thread->id)->orderBy('id', 'DESC')->first();
            }
        }

        $view = env('app.theme') === 'connectsphere' ? 'messages/index' : 'messages/index';
        return view($view, $data);
    }

    /**
     * Display a single message thread.
     */
    public function show(int $threadId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/account/login');
        }

        $userId = auth()->id();

        // Security check: ensure user is a recipient of this thread
        $recipients = new MessagesRecipientModel();
        $isRecipient = $recipients->where('thread_id', $threadId)->where('user_id', $userId)->first();
        if ($isRecipient === null) {
            return redirect()->to('/messages')->with('error', 'You are not authorized to view this message thread.');
        }

        $threads = new MessagesThreadModel();
        $messages = new MessageModel();
        $users = new UserModel();

        $thread = $threads->find($threadId);
        $threadMessages = $messages->where('thread_id', $threadId)->orderBy('id', 'ASC')->findAll();

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

        $view = env('app.theme') === 'connectsphere' ? 'messages/show' : 'messages/show';
        return view($view, $data);
    }

    /**
     * Handle a reply to a message thread.
     */
    public function reply(int $threadId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/account/login');
        }

        $userId = auth()->id();

        // Security check: ensure user is a recipient of this thread
        $recipients = new MessagesRecipientModel();
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
        $messages = new MessageModel();
        $data = [
            'thread_id' => $threadId,
            'sender_id' => $userId,
            'message'   => esc($messageText),
        ];

        if ($messages->insert($data) === false) {
            return redirect()->back()->with('error', 'Could not send the message.');
        }

        return redirect()->to('/messages/' . $threadId)->with('message', 'Reply sent!');
    }

    /**
     * Show the form for creating a new message thread.
     */
    public function new()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/account/login');
        }

        $users = new UserModel();
        $data = ['users' => $users->findAll()];

        $view = env('app.theme') === 'connectsphere' ? 'messages/new' : 'messages/new';
        return view($view, $data);
    }

    /**
     * Process the creation of a new message thread.
     */
    public function create()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to('/account/login');
        }

        // Validate the form data
        $rules = [
            'recipient' => 'required|integer',
            'message'   => 'required',
        ];
        if (env('app.theme') !== 'connectsphere') {
            $rules['subject'] = 'required|max_length[255]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $recipientId = $this->request->getPost('recipient');
        $subject = $this->request->getPost('subject') ?? '';
        $messageText = $this->request->getPost('message');

        // Create a new thread
        $threads = new MessagesThreadModel();
        $threadId = $threads->insert(['subject' => esc($subject)]);

        if ($threadId === false) {
            return redirect()->back()->with('error', 'Could not create the message thread.');
        }

        // Add recipients to the thread
        $recipients = new MessagesRecipientModel();
        $recipients->insert(['thread_id' => $threadId, 'user_id' => auth()->id()]);
        $recipients->insert(['thread_id' => $threadId, 'user_id' => $recipientId]);

        // Add the first message
        $messages = new MessageModel();
        $messages->insert([
            'thread_id' => $threadId,
            'sender_id' => auth()->id(),
            'message'   => esc($messageText),
        ]);

        return redirect()->to('/messages/' . $threadId)->with('message', 'Message sent!');
    }
}
