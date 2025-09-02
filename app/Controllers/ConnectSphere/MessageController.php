<?php

namespace App\Controllers\ConnectSphere;

use App\Controllers\BaseController;
use App\Models\ThreadModel;
use App\Models\MessageModel;
use App\Models\ThreadParticipantModel;
use CodeIgniter\Shield\Models\UserModel;

class MessageController extends BaseController
{
    public function index()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $userId = auth()->id();
        $threads = $this->getUserThreads($userId);

        return view('messages/index', ['threads' => $threads]);
    }

    public function show(int $threadId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $userId = auth()->id();

        // Security check: ensure user is a participant of this thread
        $participantModel = new ThreadParticipantModel();
        $isParticipant = $participantModel->where('thread_id', $threadId)->where('user_id', $userId)->first();
        if ($isParticipant === null) {
            return redirect()->to('/messages')->with('error', 'You are not authorized to view this message thread.');
        }

        $threadModel = new ThreadModel();
        $messageModel = new MessageModel();
        $userModel = new UserModel();

        $thread = $threadModel->find($threadId);
        $messages = $messageModel->where('thread_id', $threadId)->orderBy('created_at', 'ASC')->findAll();

        // Get user info for each message
        if (!empty($messages)) {
            $senderIds = array_map(fn($m) => $m['user_id'], $messages);
            $senders = $userModel->whereIn('id', array_unique($senderIds))->findAll();
            $senderMap = array_column($senders, null, 'id');

            foreach($messages as &$message) {
                $message['sender'] = $senderMap[$message['user_id']] ?? null;
            }
        }

        $data = [
            'thread'   => $thread,
            'messages' => array_filter($messages, fn($m) => $m['sender'] !== null),
            'threads' => $this->getUserThreads($userId),
        ];

        return view('messages/show', $data);
    }

    private function getUserThreads(int $userId): array
    {
        $participantModel = new ThreadParticipantModel();
        $threadModel = new ThreadModel();
        $messageModel = new MessageModel();
        $userModel = new UserModel();

        $threads = $participantModel
            ->select('threads.*')
            ->join('threads', 'threads.id = thread_participants.thread_id')
            ->where('thread_participants.user_id', $userId)
            ->findAll();

        foreach ($threads as &$thread) {
            // Get participants
            $participants = $participantModel->where('thread_id', $thread['id'])->findAll();
            $participantIds = array_column($participants, 'user_id');
            $otherParticipantIds = array_diff($participantIds, [$userId]);
            $thread['participants'] = $userModel->whereIn('id', $otherParticipantIds)->findAll();

            // Get last message
            $thread['last_message'] = $messageModel->where('thread_id', $thread['id'])->orderBy('created_at', 'DESC')->first();
        }

        return $threads;
    }

    public function new()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $userModel = new UserModel();
        $users = $userModel->findAll();

        return view('messages/new', ['users' => $users]);
    }

    public function create()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $rules = [
            'recipient' => 'required|integer',
            'content'   => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userId = auth()->id();
        $recipientId = $this->request->getPost('recipient');
        $content = $this->request->getPost('content');

        // Create a new thread
        $threadModel = new ThreadModel();
        $threadId = $threadModel->insert(['subject' => '']);

        if ($threadId === false) {
            return redirect()->back()->with('error', 'Could not create the message thread.');
        }

        // Add participants to the thread
        $participantModel = new ThreadParticipantModel();
        $participantModel->insert(['thread_id' => $threadId, 'user_id' => $userId]);
        $participantModel->insert(['thread_id' => $threadId, 'user_id' => $recipientId]);

        // Add the first message
        $messageModel = new MessageModel();
        $messageModel->insert([
            'thread_id' => $threadId,
            'user_id'   => $userId,
            'content'   => esc($content),
        ]);

        return redirect()->to('/messages/' . $threadId)->with('message', 'Message sent!');
    }

    public function reply(int $threadId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $userId = auth()->id();

        // Security check: ensure user is a participant of this thread
        $participantModel = new ThreadParticipantModel();
        $isParticipant = $participantModel->where('thread_id', $threadId)->where('user_id', $userId)->first();
        if ($isParticipant === null) {
            return redirect()->to('/messages')->with('error', 'You are not authorized to reply to this message thread.');
        }

        $content = $this->request->getPost('content');
        if (empty($content)) {
            return redirect()->back()->with('error', 'Message cannot be empty.');
        }

        $messageModel = new MessageModel();
        $messageModel->insert([
            'thread_id' => $threadId,
            'user_id'   => $userId,
            'content'   => esc($content),
        ]);

        return redirect()->to('/messages/' . $threadId)->with('message', 'Reply sent!');
    }
}
