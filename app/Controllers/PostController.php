<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\LikeModel;
use App\Models\CommentModel;

class PostController extends BaseController
{
    public function create()
    {
        if (!auth()->loggedIn()) {
            return redirect()->to(route_to('login'));
        }

        $content = $this->request->getPost('content');
        if (empty($content)) {
            return redirect()->back()->with('error', 'Post content cannot be empty.');
        }

        $postModel = new PostModel();
        $postModel->insert([
            'user_id' => auth()->id(),
            'content' => $content,
        ]);

        return redirect()->back()->with('message', 'Post created successfully.');
    }

    public function like(int $postId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to(route_to('login'));
        }

        $likeModel = new LikeModel();

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

        $commentModel = new CommentModel();
        $commentModel->insert([
            'post_id' => $postId,
            'user_id' => $userId,
            'content' => $content,
        ]);

        return redirect()->back()->with('message', 'Comment posted.');
    }
}
