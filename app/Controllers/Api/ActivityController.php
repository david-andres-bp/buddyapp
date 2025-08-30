<?php

namespace App\Controllers\Api;

use App\Libraries\AIAnalysis;
use App\Models\ActivityModel;
use App\Models\UserMetaModel;
use CodeIgniter\RESTful\ResourceController;

class ActivityController extends ResourceController
{
    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        // Get the logged in user's ID
        $userId = auth()->id();
        if (!$userId) {
            return $this->failUnauthorized('You must be logged in to create an activity.');
        }

        // Get the content from the request
        $content = $this->request->getPost('content');
        $attachment = $this->request->getFile('attachment');

        // Validate the content
        if (empty($content) && !$attachment) {
            return $this->failValidationErrors('Content or an attachment is required.');
        }

        // Prepare the data for the model
        $data = [
            'user_id'   => $userId,
            'component' => 'activity',
            'type'      => 'new_activity',
            'content'   => esc($content),
        ];

        // Handle file upload
        if ($attachment && $attachment->isValid() && !$attachment->hasMoved()) {
            $newName = $attachment->getRandomName();
            $attachment->move(FCPATH . 'uploads', $newName);
            $data['attachment_url'] = '/uploads/' . $newName;
        }

        // Save the activity
        $activities = new ActivityModel();
        if ($activities->insert($data) === false) {
            return $this->failServerError('Could not save the activity.', 500, $activities->errors());
        }

        // Trigger AI analysis and update user's personality tags
        if (!empty($content)) {
            $this->updatePersonalityTags($userId, $content);
        }

        return $this->respondCreated(['message' => 'Activity posted successfully!']);
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $activities = new ActivityModel();
        $activity = $activities->find($id);

        if ($activity === null) {
            return $this->failNotFound('Activity not found.');
        }

        // Check if the user is authorized to delete this activity
        if ($activity->user_id !== auth()->id()) {
            return $this->failForbidden('You are not authorized to delete this activity.');
        }

        if ($activities->delete($id)) {
            return $this->respondDeleted(['message' => 'Activity deleted successfully.']);
        }

        return $this->failServerError('Could not delete the activity.');
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $activities = new ActivityModel();
        $activity = $activities->find($id);

        if ($activity === null) {
            return $this->failNotFound('Activity not found.');
        }

        // Check if the user is authorized to edit this activity
        if ($activity->user_id !== auth()->id()) {
            return $this->failForbidden('You are not authorized to edit this activity.');
        }

        // Get the content from the request
        $content = $this->request->getPost('content');

        // Validate the content
        if (empty($content)) {
            return $this->failValidationErrors('Content is required.');
        }

        $data = [
            'content' => esc($content),
        ];

        if ($activities->update($id, $data) === false) {
            return $this->failServerError('Could not update the activity.', 500, $activities->errors());
        }

        // We could potentially re-analyze the content for personality tags here
        // but for now, we'll skip it to keep the edit lightweight.

        return $this->respondUpdated(['message' => 'Activity updated successfully!']);
    }

    /**
     * Analyzes content and updates the user's personality tags.
     */
    private function updatePersonalityTags(int $userId, string $content): void
    {
        $analysis = new AIAnalysis();
        $newTags = $analysis->analyzeText($content);

        if (empty($newTags)) {
            return;
        }

        $meta = new UserMetaModel();

        // Get existing tags
        $existing = $meta->where('user_id', $userId)->where('meta_key', 'personality_tags')->first();

        $existingTags = [];
        if ($existing) {
            $existingTags = json_decode($existing->meta_value, true) ?? [];
        }

        // Merge and save unique tags
        $allTags = array_unique(array_merge($existingTags, $newTags));

        $metaData = [
            'user_id'    => $userId,
            'meta_key'   => 'personality_tags',
            'meta_value' => json_encode($allTags),
        ];

        // Use `save` which handles insert/update
        if ($existing) {
            $meta->update($existing->id, $metaData);
        } else {
            $meta->insert($metaData);
        }
    }
}
