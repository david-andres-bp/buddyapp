<?php

namespace App\Controllers;

use CodeIgniter\Shield\Models\UserModel;

class NotificationController extends BaseController
{
    public function index()
    {
        // Check if the user is logged in
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        // Get the current user's ID
        $userId = auth()->id();
        $userModel = new UserModel();
        $currentUser = $userModel->find($userId);

        // Fetch all notifications for the user
        $activityModel = new \App\Models\ActivityModel();
        $notifications = $activityModel->where('component', 'notifications')
                                       ->where('user_id', $userId)
                                       ->orderBy('created_at', 'DESC')
                                       ->findAll();

        // Get user information for each notification
        foreach ($notifications as &$notification) {
            if ($notification->type === 'new_follower') {
                $follower = $userModel->find($notification->content);
                $notification->follower = $follower;
            }
        }

        // Get follower/following counts
        $connectionModel = new \App\Models\ConnectionModel();
        $followersCount = $connectionModel->where('friend_user_id', $userId)->where('status', 'accepted')->countAllResults();
        $followingCount = $connectionModel->where('initiator_user_id', $userId)->where('status', 'accepted')->countAllResults();

        $data = [
            'notifications' => $notifications,
            'currentUser' => $currentUser,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
        ];

        // Pass the notifications to the view
        return view('notifications', $data);
    }
}
