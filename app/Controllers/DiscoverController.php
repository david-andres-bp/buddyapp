<?php

namespace App\Controllers;

use App\Models\UserMetaModel;
use CodeIgniter\Shield\Models\UserModel;

class DiscoverController extends BaseController
{
    public function index()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        $users = new UserModel();
        $meta = new UserMetaModel();

        // Define the tags we want to feature on the Discover page
        $featuredTags = ['adventurous', 'creative', 'foodie', 'sporty', 'intellectual'];
        $usersByTag = [];

        foreach ($featuredTags as $tag) {
            // Find users with this tag.
            // NOTE: This LIKE query is not efficient for large datasets due to the JSON storage.
            // A normalized schema would be better.
            $userMetas = $meta
                ->where('meta_key', 'personality_tags')
                ->like('meta_value', '"' . $tag . '"')
                ->findAll(10); // Limit to 10 users per tag for performance

            if (empty($userMetas)) {
                $usersByTag[$tag] = [];
                continue;
            }

            $userIds = array_map(fn($m) => $m->user_id, $userMetas);

            // Fetch the user objects for these IDs
            $usersByTag[$tag] = $users->whereIn('id', $userIds)->findAll();
        }

        // Fetch recent activities
        $activities = new \App\Models\ActivityModel();
        $recentActivities = $activities->orderBy('created_at', 'DESC')->findAll(20); // Get latest 20

        // Get user info for recent activities
        if (!empty($recentActivities)) {
            $userIds = array_map(fn($a) => $a->user_id, $recentActivities);
            $activityUsers = $users->whereIn('id', array_unique($userIds))->findAll();
            $userMap = array_column($activityUsers, null, 'id');

            foreach($recentActivities as $activity) {
                $activity->user = $userMap[$activity->user_id] ?? null;
            }
        }

        $data = [
            'usersByTag'       => $usersByTag,
            'recentActivities' => $recentActivities ?? [],
        ];

        return view('discover', $data);
    }
}
