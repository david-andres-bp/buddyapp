<?php

namespace App\Controllers;

use App\Models\UserMetaModel;
use CodeIgniter\Shield\Models\UserModel;

class DiscoverController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $metaModel = new UserMetaModel();

        // Get current page from query string, default to 1
        $page = $this->request->getVar('page') ?? 1;
        $perPage = 12; // Number of users per page

        // Get all users with pagination
        $users = $userModel->paginate($perPage);

        // Get the pager
        $pager = $userModel->pager;

        // Eager load meta data for the paginated users
        if (!empty($users)) {
            $userIds = array_column($users, 'id');
            $metaData = $metaModel->whereIn('user_id', $userIds)->findAll();

            // Create a map of user_id => meta fields
            $metaMap = [];
            foreach ($metaData as $meta) {
                if (!isset($metaMap[$meta->user_id])) {
                    $metaMap[$meta->user_id] = [];
                }
                $metaMap[$meta->user_id][$meta->meta_key] = $meta->meta_value;
            }

            // Attach meta data to each user object
            foreach ($users as $user) {
                $user->meta = (object) ($metaMap[$user->id] ?? []);
            }
        }

        $data = [
            'users' => $users,
            'pager' => $pager,
        ];

        // The view name is 'discover'. The ThemeView library will find
        // 'discover.php' in the active theme's folder.
        return view('discover', $data);
    }
}
