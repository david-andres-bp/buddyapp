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

        // This logic should use the `connections` table for follows
        $connectionModel = new ConnectionModel();
        $connections = $connectionModel
            ->where('initiator_user_id', $userId)
            ->where('status', 'accepted')
            ->findAll();
        $followedUserIds = array_column($connections, 'friend_user_id');

        // Add the current user's ID to the list, so they see their own posts
        $followedUserIds[] = $userId;

        // Get all the posts from the followed users
        $activityModel = new ActivityModel();
        $posts = $activityModel->where('component', 'posts')
                               ->whereIn('user_id', $followedUserIds)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        // Get user information, like counts, and comment counts for each post
        $hydratedPosts = [];
        foreach ($posts as $post) {
            $user = $userModel->find($post->user_id);
            if ($user) {
                $post->user = $user;
                $post->like_count = $activityModel->where('component', 'likes')->where('content', $post->id)->countAllResults();
                $post->is_liked_by_user = $activityModel->where('component', 'likes')->where('content', $post->id)->where('user_id', $userId)->countAllResults() > 0;
                $post->comment_count = $activityModel->where('component', 'comments')->where('content', 'like', '"post_id":"' . $post->id . '"')->countAllResults();
                $hydratedPosts[] = $post;
            }
        }
        $posts = $hydratedPosts;

        // Get follower/following counts
        $followersCount = $connectionModel->where('friend_user_id', $userId)->where('status', 'accepted')->countAllResults();
        $followingCount = $connectionModel->where('initiator_user_id', $userId)->where('status', 'accepted')->countAllResults();

        // Get "Who to Follow" suggestions
        $suggestions = []; // This would need a more complex query to be accurate

        // Get trending topics
        $allPosts = $activityModel->where('component', 'posts')->findAll();
        $hashtags = [];
        foreach ($allPosts as $post) {
            preg_match_all('/#(\w+)/', $post->content, $matches);
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
            'suggestions' => $suggestions,
            'trending' => $trending,
        ];

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

    public function post()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $content = $this->request->getPost('content');
        if (empty($content)) {
            return redirect()->back()->with('error', 'Post content cannot be empty.');
        }

        $activityModel = new ActivityModel();
        $activityModel->insert([
            'user_id'   => auth()->id(),
            'component' => 'posts',
            'type'      => 'new_post',
            'content'   => $content,
        ]);

        return redirect()->back()->with('message', 'Post created successfully.');
    }

    public function like(int $activityId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $activityModel = new ActivityModel();
        $like = $activityModel->where('component', 'likes')
                              ->where('type', 'new_like')
                              ->where('content', $activityId)
                              ->where('user_id', auth()->id())
                              ->first();

        if ($like) {
            // Unlike
            $activityModel->delete($like->id);
        } else {
            // Like
            $activityModel->insert([
                'user_id'   => auth()->id(),
                'component' => 'likes',
                'type'      => 'new_like',
                'content'   => $activityId,
            ]);
        }

        return redirect()->back();
    }

    public function comment(int $activityId)
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $content = $this->request->getPost('content');
        if (empty($content)) {
            return redirect()->back()->with('error', 'Comment cannot be empty.');
        }

        $activityModel = new ActivityModel();
        $activityModel->insert([
            'user_id'   => auth()->id(),
            'component' => 'comments',
            'type'      => 'new_comment',
            'content'   => json_encode(['post_id' => $activityId, 'text' => $content]),
        ]);

        return redirect()->back()->with('message', 'Comment posted.');
    }
}
