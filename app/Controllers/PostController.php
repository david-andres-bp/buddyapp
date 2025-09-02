<?php

namespace App\Controllers;

use App\Models\PostModel;
use CodeIgniter\API\ResponseTrait;

class PostController extends BaseController
{
    use ResponseTrait;

    public function create()
    {
        // Check if the user is logged in
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        // Get the post content from the request
        $content = $this->request->getPost('content');

        // Validate the content
        if (empty($content)) {
            return redirect()->back()->with('error', 'Post content cannot be empty.');
        }

        // Get the current user's ID
        $userId = auth()->id();

        // Create the new post
        $postModel = new PostModel();
        $postModel->insert([
            'user_id' => $userId,
            'content' => $content,
        ]);

        // Redirect back to the homepage with a success message
        return redirect()->to(route_to('home'))->with('message', 'Post created successfully.');
    }

    public function like(int $postId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $likeModel = new \App\Models\LikeModel();

        $existingLike = $likeModel->where('user_id', $userId)
                                  ->where('post_id', $postId)
                                  ->first();

        if ($existingLike) {
            // Unlike the post
            $likeModel->where('user_id', $userId)
                      ->where('post_id', $postId)
                      ->delete();
        } else {
            // Like the post
            $likeModel->insert([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
        }

        return redirect()->back();
    }

    public function comment(int $postId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $content = $this->request->getPost('content');
        if (empty($content)) {
            return redirect()->back()->with('error', 'Comment cannot be empty.');
        }

        $commentModel = new \App\Models\CommentModel();
        $commentModel->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content,
        ]);

        return redirect()->back()->with('message', 'Comment posted.');
    }
}
