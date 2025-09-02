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
}
