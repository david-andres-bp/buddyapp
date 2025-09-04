<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\UserMetaModel;
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

        $activityModel = new \App\Models\ActivityModel();

        // 1. Fetch User's Posts
        $posts = $activityModel->where('component', 'posts')
                               ->where('user_id', $user->id)
                               ->orderBy('created_at', 'DESC')
                               ->findAll();

        // 2. Fetch User's Liked Posts
        $likedPostIds = $activityModel->where('component', 'likes')
                                      ->where('user_id', $user->id)
                                      ->findColumn('content') ?? [];
        $likedPosts = [];
        if (!empty($likedPostIds)) {
            $likedPosts = $activityModel->where('component', 'posts')
                                        ->whereIn('id', $likedPostIds)
                                        ->orderBy('created_at', 'DESC')
                                        ->findAll();
        }

        // 3. Fetch User's Media Posts
        $mediaPosts = array_filter($posts, static function ($post) {
            // Simple check for image extensions or img tags
            return str_contains($post->content, '<img') || preg_match('/\.(jpg|jpeg|png|gif)/i', $post->content);
        });

        // 4. Hydrate all posts with author and interaction data
        $allPosts = array_merge($posts, $likedPosts);
        if (!empty($allPosts)) {
            $userModel = new \CodeIgniter\Shield\Models\UserModel();
            $currentUserId = auth()->id();

            foreach ($allPosts as $p) {
                if (isset($p->user)) {
                    continue; // Already hydrated
                }
                $author = $userModel->find($p->user_id);
                if ($author) {
                    $p->user = $author;
                    $p->like_count = $activityModel->where('component', 'likes')->where('content', $p->id)->countAllResults();
                    $p->is_liked_by_user = $currentUserId ? ($activityModel->where('component', 'likes')->where('content', $p->id)->where('user_id', $currentUserId)->countAllResults() > 0) : false;
                    $p->comment_count = $activityModel->where('component', 'comments')->like('content', '"post_id":' . $p->id)->countAllResults();
                }
            }
        }

        // 5. Fetch follower/following counts and status
        $connectionModel = new \App\Models\ConnectionModel();
        $followersCount = $connectionModel->where('friend_user_id', $user->id)->where('status', 'accepted')->countAllResults();
        $followingCount = $connectionModel->where('initiator_user_id', $user->id)->where('status', 'accepted')->countAllResults();

        $isFollowing = false;
        if (auth()->loggedIn() && auth()->id() !== $user->id) {
            $isFollowing = $connectionModel->where('initiator_user_id', auth()->id())
                                           ->where('friend_user_id', $user->id)
                                           ->where('status', 'accepted')
                                           ->countAllResults() > 0;
        }

        $data = [
            'user'           => $user,
            'posts'          => $posts,
            'likedPosts'     => $likedPosts,
            'mediaPosts'     => $mediaPosts,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'isFollowing'    => $isFollowing,
            'currentUser'    => auth()->user(),
        ];

        // Use the theme-aware renderer to load the view within the main layout.
        // The ThemeView library will look for 'profile/show.php'.
        return view('profile/show', $data);
    }
}
