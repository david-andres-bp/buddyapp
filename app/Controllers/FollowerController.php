<?php

namespace App\Controllers;

use App\Models\FollowerModel;

class FollowerController extends BaseController
{
    public function follow(int $followedId)
    {
        $followerId = auth()->id();
        if (!$followerId) {
            return redirect()->to(route_to('login'));
        }

        if ($followerId === $followedId) {
            return redirect()->back()->with('error', 'You cannot follow yourself.');
        }

        $followerModel = new FollowerModel();
        $followerModel->insert([
            'follower_id' => $followerId,
            'followed_id' => $followedId,
        ]);

        return redirect()->back()->with('message', 'You are now following this user.');
    }

    public function unfollow(int $followedId)
    {
        $followerId = auth()->id();
        if (!$followerId) {
            return redirect()->to(route_to('login'));
        }

        $followerModel = new FollowerModel();
        $followerModel->where('follower_id', $followerId)
                      ->where('followed_id', $followedId)
                      ->delete();

        return redirect()->back()->with('message', 'You have unfollowed this user.');
    }
}
