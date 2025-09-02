<?php

namespace App\Controllers\ConnectSphere;

use App\Controllers\ConnectionController as BaseConnectionController;

class ConnectionController extends BaseConnectionController
{
    public function create(int $friendUserId)
    {
        return redirect()->to(route_to('home'));
    }

    public function index()
    {
        return redirect()->to(route_to('home'));
    }

    public function accept(int $requestId)
    {
        return redirect()->to(route_to('home'));
    }

    public function decline(int $requestId)
    {
        return redirect()->to(route_to('home'));
    }

    public function follow(int $followedId)
    {
        $followerId = auth()->id();
        if (!$followerId) {
            return redirect()->to(route_to('login'));
        }

        if ($followerId === $followedId) {
            return redirect()->back()->with('error', 'You cannot follow yourself.');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('followers');

        // Check if already following
        $builder->where('follower_id', $followerId);
        $builder->where('followed_id', $followedId);
        if ($builder->countAllResults() > 0) {
            return redirect()->back()->with('error', 'You are already following this user.');
        }

        // Create the follow relationship
        $builder->insert([
            'follower_id' => $followerId,
            'followed_id' => $followedId,
        ]);

        // Create a notification
        $notificationModel = new \App\Models\NotificationModel();
        $notificationModel->insert([
            'user_id' => $followedId,
            'type'    => 'new_follower',
            'data'    => json_encode(['follower_id' => $followerId]),
        ]);

        return redirect()->back()->with('message', 'You are now following this user.');
    }

    public function unfollow(int $followedId)
    {
        $followerId = auth()->id();
        if (!$followerId) {
            return redirect()->to(route_to('login'));
        }

        $db = \Config\Database::connect();
        $builder = $db->table('followers');

        // Delete the follow relationship
        $builder->where('follower_id', $followerId);
        $builder->where('followed_id', $followedId);
        $builder->delete();

        return redirect()->back()->with('message', 'You have unfollowed this user.');
    }
}
