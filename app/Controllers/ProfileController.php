<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\UserMetaModel;
use App\Models\PostModel;
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
            // Fetch the user's posts
            $postModel = new PostModel();
            $posts = $postModel->where('user_id', $user->id)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();
            $data['posts'] = $posts;

            // Check if the current user is following this user
            $isFollowing = false;
            if (auth()->loggedIn()) {
                $db = \Config\Database::connect();
                $builder = $db->table('followers');
                $builder->where('follower_id', auth()->id());
                $builder->where('followed_id', $user->id);
                $isFollowing = $builder->countAllResults() > 0;
            }
            $data['isFollowing'] = $isFollowing;

            // Check if the current user has pinned this profile
            $isPinned = false;
            if (auth()->loggedIn()) {
                $pinnedProfileModel = new \App\Models\PinnedProfileModel();
                $isPinned = $pinnedProfileModel->where('user_id', auth()->id())
                                               ->where('pinned_user_id', $user->id)
                                               ->countAllResults() > 0;
            }
            $data['isPinned'] = $isPinned;

            // Get follower/following counts
            $followersCount = $db->table('followers')->where('followed_id', $user->id)->countAllResults();
            $followingCount = $db->table('followers')->where('follower_id', $user->id)->countAllResults();
            $data['followersCount'] = $followersCount;
            $data['followingCount'] = $followingCount;
        }

        // The ThemeView library will look for 'profile.php' in the theme's Views folder.
        return view('profile', $data);
    }

    public function pin(int $pinnedUserId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $pinnedProfileModel = new \App\Models\PinnedProfileModel();
        $pinnedProfileModel->insert([
            'user_id' => $userId,
            'pinned_user_id' => $pinnedUserId,
        ]);

        return redirect()->back()->with('message', 'Profile pinned.');
    }

    public function unpin(int $pinnedUserId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $pinnedProfileModel = new \App\Models\PinnedProfileModel();
        $pinnedProfileModel->where('user_id', $userId)
                           ->where('pinned_user_id', $pinnedUserId)
                           ->delete();

        return redirect()->back()->with('message', 'Profile unpinned.');
    }
}
