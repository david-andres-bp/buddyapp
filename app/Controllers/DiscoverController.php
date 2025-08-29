<?php

namespace App\Controllers;

use App\Models\UserMetaModel;
use CodeIgniter\Shield\Models\UserModel;

class DiscoverController extends BaseController
{
    public function index()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        $users = new UserModel();
        $meta = new UserMetaModel();

        // Define the tags we want to feature on the Discover page
        $featuredTags = ['adventurous', 'creative', 'foodie', 'sporty', 'intellectual'];
        $usersByTag = [];

        foreach ($featuredTags as $tag) {
            // Find users with this tag.
            // NOTE: This LIKE query is not efficient for large datasets due to the JSON storage.
            // A normalized schema would be better.
            $userMetas = $meta
                ->where('meta_key', 'personality_tags')
                ->like('meta_value', '"' . $tag . '"')
                ->findAll(10); // Limit to 10 users per tag for performance

            if (empty($userMetas)) {
                $usersByTag[$tag] = [];
                continue;
            }

            $userIds = array_map(fn($m) => $m->user_id, $userMetas);

            // Fetch the user objects for these IDs
            $usersByTag[$tag] = $users->whereIn('id', $userIds)->findAll();
        }

        return view('discover', ['usersByTag' => $usersByTag]);
    }
}
