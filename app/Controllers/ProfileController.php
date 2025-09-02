<?php

namespace App\Controllers;

use App\Models\UserMetaModel;
use App\Models\PostModel;
use App\Models\LikeModel;
use App\Models\FollowerModel;
use CodeIgniter\Shield\Models\UserModel;

class ProfileController extends BaseController
{
    public function show(string $username)
    {
        // Find the user by username
        $userModel = new UserModel();
        $user = $userModel->where('username', $username)->first();

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Fetch all meta data for the user
        $metaModel = new UserMetaModel();
        $metaData = $metaModel->where('user_id', $user->id)->findAll();

        // Organize meta data into a simple key-value object
        $user->meta = new \stdClass();
        foreach ($metaData as $meta) {
            $user->meta->{$meta->meta_key} = $meta->meta_value;
        }

        $data = ['user' => $user];

        $activeTheme = env('app.theme');

        if ($activeTheme === 'connectsphere') {
            $postModel = new PostModel();
            $followerModel = new FollowerModel();
            $likeModel = new LikeModel();

            // Fetch the user's posts
            $posts = $postModel->where('user_id', $user->id)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();
            $data['posts'] = $posts;

            // Check if the current user is following this user
            $isFollowing = false;
            if (auth()->loggedIn()) {
                $isFollowing = $followerModel->where('follower_id', auth()->id())
                                               ->where('followed_id', $user->id)
                                               ->countAllResults() > 0;
            }
            $data['isFollowing'] = $isFollowing;

            // Get follower/following counts
            $followersCount = $followerModel->where('followed_id', $user->id)->countAllResults();
            $followingCount = $followerModel->where('follower_id', $user->id)->countAllResults();
            $data['followersCount'] = $followersCount;
            $data['followingCount'] = $followingCount;

            // Fetch liked posts
            $likedPostIds = $likeModel->where('user_id', $user->id)->findColumn('post_id');
            if (!empty($likedPostIds)) {
                $data['liked_posts'] = $postModel->whereIn('id', $likedPostIds)->findAll();
            } else {
                $data['liked_posts'] = [];
            }
        }

        // The ThemeView library will look for 'profile.php' in the theme's Views folder.
        return view('profile', $data);
    }
}
