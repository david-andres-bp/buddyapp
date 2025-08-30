<?php

namespace App\Controllers;

use App\Models\ActivityModel;
use App\Libraries\Theme;

class ActivityController extends BaseController
{
    /**
     * Shows the edit form for a single activity.
     */
    public function edit($id = null)
    {
        $activities = new ActivityModel();
        $activity = $activities->find($id);

        if ($activity === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Check if the user is authorized to edit this activity
        if ($activity->user_id !== auth()->id()) {
            return redirect()->to('/')->with('error', 'You are not authorized to edit this activity.');
        }

        return Theme::render('activity/edit', ['activity' => $activity]);
    }
}
