<?php

namespace App\Controllers;

use App\Models\ConnectionModel;

class ConnectionController extends BaseController
{
    /**
     * Create a new connection request.
     */
    public function create(int $friendUserId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login')->with('error', 'You must be logged in to connect with users.');
        }

        if ($userId === $friendUserId) {
            return redirect()->back()->with('error', 'You cannot connect with yourself.');
        }

        $connections = new ConnectionModel();

        // Check if a connection already exists
        $existing = $connections
            ->whereIn('initiator_user_id', [$userId, $friendUserId])
            ->whereIn('friend_user_id', [$userId, $friendUserId])
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'A connection request already exists with this user.');
        }

        // Create the new connection request
        $data = [
            'initiator_user_id' => $userId,
            'friend_user_id'    => $friendUserId,
            'status'            => 'pending',
        ];

        if ($connections->insert($data) === false) {
            return redirect()->back()->with('error', 'Could not send the connection request.');
        }

        return redirect()->back()->with('message', 'Connection request sent!');
    }

    /**
     * Display the user's connections and pending requests.
     */
    public function index()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        $connections = new ConnectionModel();
        $users       = new \CodeIgniter\Shield\Models\UserModel();

        // Get pending requests received
        $pendingReceived = $connections
            ->where('friend_user_id', $userId)
            ->where('status', 'pending')
            ->findAll();

        // Get user info for pending requests
        if (!empty($pendingReceived)) {
            $initiatorIds = array_map(fn ($req) => $req->initiator_user_id, $pendingReceived);
            $initiators   = $users->whereIn('id', $initiatorIds)->findAll();
            $initiatorMap = array_column($initiators, null, 'id');

            foreach ($pendingReceived as $request) {
                $request->user = $initiatorMap[$request->initiator_user_id] ?? null;
            }
        }

        // Get current connections
        $currentConnections = $connections
            ->groupStart()
                ->where('initiator_user_id', $userId)
                ->orWhere('friend_user_id', $userId)
            ->groupEnd()
            ->where('status', 'accepted')
            ->findAll();

        // Get user info for current connections
        if (!empty($currentConnections)) {
            $friendIds = [];
            foreach ($currentConnections as $conn) {
                $friendIds[] = ($conn->initiator_user_id == $userId) ? $conn->friend_user_id : $conn->initiator_user_id;
            }
            $friends   = $users->whereIn('id', array_unique($friendIds))->findAll();
            $friendMap = array_column($friends, null, 'id');

            foreach ($currentConnections as $conn) {
                $friendId      = ($conn->initiator_user_id == $userId) ? $conn->friend_user_id : $conn->initiator_user_id;
                $conn->friend = $friendMap[$friendId] ?? null;
            }
        }

        $data = [
            'pendingReceived'    => array_filter($pendingReceived, fn($req) => $req->user !== null),
            'currentConnections' => array_filter($currentConnections, fn($conn) => $conn->friend !== null),
        ];

        return view('connections/index', $data);
    }

    /**
     * Accept a connection request.
     */
    public function accept(int $requestId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        $connections = new ConnectionModel();
        $request = $connections->find($requestId);

        // Ensure the request exists and is for the current user
        if ($request === null || $request->friend_user_id != $userId) {
            return redirect()->back()->with('error', 'Invalid connection request.');
        }

        // Update the status to 'accepted'
        if ($connections->update($requestId, ['status' => 'accepted']) === false) {
            return redirect()->back()->with('error', 'Could not accept the connection request.');
        }

        return redirect()->back()->with('message', 'Connection accepted!');
    }

    /**
     * Decline a connection request.
     */
    public function decline(int $requestId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        $connections = new ConnectionModel();
        $request = $connections->find($requestId);

        // Ensure the request exists and is for the current user
        if ($request === null || $request->friend_user_id != $userId) {
            return redirect()->back()->with('error', 'Invalid connection request.');
        }

        // Decline by deleting the request
        if ($connections->delete($requestId) === false) {
            return redirect()->back()->with('error', 'Could not decline the connection request.');
        }

        return redirect()->back()->with('message', 'Connection declined.');
    }
}
