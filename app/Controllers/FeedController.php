<?php

namespace App\Controllers;

use App\Models\ConnectionModel;
use App\Models\ActivityModel;
use App\Models\PostModel;
use CodeIgniter\Shield\Models\UserModel;

class FeedController extends BaseController
{
    public function index()
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $activeTheme = env('app.theme');

        if ($activeTheme === 'connectsphere') {
            return $this->connectsphereFeed($userId);
        }

        return $this->datingFeed($userId);
    }

    protected function connectsphereFeed(int $userId)
    {
        $userModel = new UserModel();
        $currentUser = $userModel->find($userId);

        // Get the list of users that the current user follows
        $db = \Config\Database::connect();
        $builder = $db->table('followers');
        $builder->where('follower_id', $userId);
        $followedUsers = $builder->get()->getResultArray();
        $followedUserIds = array_column($followedUsers, 'followed_id');

        // Add the current user's ID to the list, so they see their own posts
        $followedUserIds[] = $userId;

        // Get all the posts from the followed users
        $postModel = new PostModel();
        $posts = $postModel->whereIn('user_id', $followedUserIds)
                           ->orderBy('created_at', 'DESC')
                           ->findAll();

        // Get user information for each post
        foreach ($posts as &$post) {
            $user = $userModel->find($post['user_id']);
            $post['user'] = $user;
        }

        // Get follower/following counts
        $followersCount = $db->table('followers')->where('followed_id', $userId)->countAllResults();
        $followingCount = $db->table('followers')->where('follower_id', $userId)->countAllResults();

        // Get pinned profiles
        $pinnedProfileModel = new \App\Models\PinnedProfileModel();
        $pinnedProfiles = $pinnedProfileModel
            ->select('users.*')
            ->join('users', 'users.id = pinned_profiles.pinned_user_id')
            ->where('pinned_profiles.user_id', $userId)
            ->findAll();

        // Get "Who to Follow" suggestions
        $subquery = $db->table('followers')->select('followed_id')->where('follower_id', $userId);
        $suggestions = $userModel->where('id !=', $userId)
                                 ->whereNotIn('id', $subquery)
                                 ->limit(5)
                                 ->findAll();

        // Get trending topics
        $allPosts = $postModel->findAll();
        $hashtags = [];
        foreach ($allPosts as $post) {
            preg_match_all('/#(\w+)/', $post['content'], $matches);
            if (!empty($matches[1])) {
                $hashtags = array_merge($hashtags, $matches[1]);
            }
        }
        $trending = array_count_values($hashtags);
        arsort($trending);
        $trending = array_slice($trending, 0, 5);

        $data = [
            'posts' => $posts,
            'currentUser' => $currentUser,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'pinnedProfiles' => $pinnedProfiles,
            'suggestions' => $suggestions,
            'trending' => $trending,
        ];

        // Pass the posts to the view
        return view('home', $data);
    }

    protected function datingFeed(int $userId)
    {
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
