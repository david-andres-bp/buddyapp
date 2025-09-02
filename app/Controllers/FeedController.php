<?php

namespace App\Controllers;

use App\Models\ConnectionModel;
use App\Models\ActivityModel;
use CodeIgniter\Shield\Models\UserModel;

class FeedController extends BaseController
{
    public function index()
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $connectionModel = new ConnectionModel();
        $activityModel = new ActivityModel();
        $userModel = new UserModel();

        // Step 1: Get the IDs of all the user's connections
        $connections = $connectionModel
            ->groupStart()
                ->where('initiator_user_id', $userId)
                ->orWhere('friend_user_id', $userId)
            ->groupEnd()
            ->where('status', 'accepted')
            ->findAll();

        $connectionIds = [];
        if (!empty($connections)) {
            foreach ($connections as $conn) {
                $connectionIds[] = ($conn->initiator_user_id == $userId)
                    ? $conn->friend_user_id
                    : $conn->initiator_user_id;
            }
        }

        $activities = [];
        if (!empty($connectionIds)) {
            // Step 2: Get all activities from those connections
            $activities = $activityModel
                ->whereIn('user_id', $connectionIds)
                ->orderBy('created_at', 'DESC')
                ->findAll(30); // Limit to latest 30 activities

            // Step 3: Get user data for each activity
            if (!empty($activities)) {
                $activityUserIds = array_unique(array_column($activities, 'user_id'));
                $activityUsers = $userModel->whereIn('id', $activityUserIds)->findAll();
                $userMap = array_column($activityUsers, null, 'id');

                foreach ($activities as $activity) {
                    $activity->user = $userMap[$activity->user_id] ?? null;
                }
            }
        }

        $data = [
            'activities' => array_filter($activities, fn($a) => $a->user !== null),
        ];

        return view('feed/index', $data);
    }
}
