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

        // Get filter criteria from the request
        $filters = [
            'location' => $this->request->getGet('location'),
            'age_min'  => $this->request->getGet('age_min'),
            'age_max'  => $this->request->getGet('age_max'),
        ];

        // Start building the query
        $userModel->select('users.*');

        // Handle location filter
        if (!empty($filters['location'])) {
            $userModel->join('user_meta as meta_location', "meta_location.user_id = users.id AND meta_location.meta_key = 'location'", 'inner');
            $userModel->like('meta_location.meta_value', $filters['location']);
        }

        // Handle age filters
        if (!empty($filters['age_min'])) {
            $userModel->join('user_meta as meta_age_min', "meta_age_min.user_id = users.id AND meta_age_min.meta_key = 'age'", 'inner');
            $userModel->where('meta_age_min.meta_value >=', (int)$filters['age_min']);
        }
        if (!empty($filters['age_max'])) {
            $userModel->join('user_meta as meta_age_max', "meta_age_max.user_id = users.id AND meta_age_max.meta_key = 'age'", 'inner');
            $userModel->where('meta_age_max.meta_value <=', (int)$filters['age_max']);
        }

        // Exclude the current user from the results
        if (auth()->loggedIn()) {
            $userModel->where('users.id !=', auth()->id());
        }

        // Paginate the results
        $perPage = 12;
        $users = $userModel->paginate($perPage);
        $pager = $userModel->pager;

        // Eager load all meta data for the paginated users
        if (!empty($users)) {
            $userIds = array_column($users, 'id');
            $metaData = $metaModel->whereIn('user_id', $userIds)->findAll();
            $metaMap = [];
            foreach ($metaData as $meta) {
                $metaMap[$meta->user_id][$meta->meta_key] = $meta->meta_value;
            }
            foreach ($users as $user) {
                $user->meta = (object) ($metaMap[$user->id] ?? []);
            }
        }

        $data = [
            'users'   => $users,
            'pager'   => $pager,
            'filters' => $filters, // Pass filters to the view to repopulate the form
        ];

        return view('discover', $data);
    }
}
