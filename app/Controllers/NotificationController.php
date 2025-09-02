<?php

namespace App\Controllers;

use App\Models\NotificationModel;
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
        $notificationModel = new NotificationModel();
        $notifications = $notificationModel->where('user_id', $userId)
                                           ->orderBy('created_at', 'DESC')
                                           ->findAll();

        // Get user information for each notification
        foreach ($notifications as &$notification) {
            $data = json_decode($notification['data']);
            if (isset($data->follower_id)) {
                $follower = $userModel->find($data->follower_id);
                $notification['follower'] = $follower;
            }
        }

        // Get follower/following counts
        $db = \Config\Database::connect();
        $followersCount = $db->table('followers')->where('followed_id', $userId)->countAllResults();
        $followingCount = $db->table('followers')->where('follower_id', $userId)->countAllResults();

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
