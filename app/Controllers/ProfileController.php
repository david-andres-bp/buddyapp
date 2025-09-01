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

        // The controller for the 'heartbeat' theme was fetching activities.
        // The Serendipity theme does not use this concept, so we pass
        // only the user data.

        $data = [
            'user' => $user,
        ];

        // Use the theme-aware renderer to load the view within the main layout.
        // The ThemeView library will look for 'profile/show.php'.
        return view('profile/show', $data);
    }
}
