<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Models\UserMetaModel;
use CodeIgniter\Shield\Models\UserModel;

class ProfileController extends BaseController
{
    public function show(string $username)
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        // Find the user by username
        $users = new UserModel();
        $user = $users->where('username', $username)->first();

        if ($user === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Fetch user's activities
        $activities = new ActivityModel();
        $userActivities = $activities
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        // Fetch user's personality tags
        $meta = new UserMetaModel();
        $tagsData = $meta->where('user_id', $user->id)->where('meta_key', 'personality_tags')->first();
        $tags = $tagsData ? json_decode($tagsData->meta_value, true) : [];

        $data = [
            'user'       => $user,
            'activities' => $userActivities,
            'tags'       => $tags,
        ];

        return view('profile', $data);
    }
}
