<?php

namespace App\Controllers;

class GroupController extends BaseController
{
    /**
     * Display a list of all public groups.
     */
    public function index()
    {
        $groups = new \App\Models\GroupModel();

        $data = [
            'groups' => $groups->where('status', 'public')->findAll(),
        ];

        return view('groups/index', $data);
    }

    /**
     * Show the form for creating a new group.
     */
    public function new()
    {
        return view('groups/new');
    }

    /**
     * Process the creation of a new group.
     */
    public function create()
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        // Validate the form data
        $rules = [
            'name'        => 'required|max_length[255]',
            'description' => 'required',
            'status'      => 'required|in_list[public,private,hidden]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Create the slug
        helper('text');
        $slug = url_title($this->request->getPost('name'), '-', true);

        // Prepare the data
        $data = [
            'creator_id'  => $userId,
            'name'        => $this->request->getPost('name'),
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'status'      => $this->request->getPost('status'),
        ];

        $groups = new \App\Models\GroupModel();
        if ($groups->insert($data) === false) {
            return redirect()->back()->withInput()->with('errors', $groups->errors());
        }

        // Also add the creator as the first member (admin)
        $groupMembers = new \App\Models\GroupMemberModel();
        $groupMembers->insert([
            'group_id' => $groups->getInsertID(),
            'user_id'  => $userId,
            'role'     => 'admin',
        ]);

        return redirect()->to('/groups/' . $slug)->with('message', 'Group created successfully!');
    }

    /**
     * Display a single group by its slug.
     */
    public function show(string $slug)
    {
        $groups = new \App\Models\GroupModel();
        $group = $groups->where('slug', $slug)->first();

        if ($group === null) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Fetch membership status for the current user
        $groupMembers = new \App\Models\GroupMemberModel();
        $userId = auth()->id();
        $membership = null;
        if ($userId) {
            $membership = $groupMembers->where('group_id', $group->id)->where('user_id', $userId)->first();
        }

        // TODO: Fetch group members list

        $data = [
            'group'      => $group,
            'membership' => $membership,
        ];

        return view('groups/show', $data);
    }

    /**
     * Join a group.
     */
    public function join(int $groupId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        $groupMembers = new \App\Models\GroupMemberModel();

        // Check if user is already a member
        $isMember = $groupMembers->where('group_id', $groupId)->where('user_id', $userId)->first();
        if ($isMember) {
            return redirect()->back()->with('error', 'You are already a member of this group.');
        }

        // Add the user to the group
        $data = [
            'group_id' => $groupId,
            'user_id'  => $userId,
            'role'     => 'member',
        ];

        if ($groupMembers->insert($data) === false) {
            return redirect()->back()->with('error', 'Could not join the group.');
        }

        return redirect()->back()->with('message', 'You have joined the group!');
    }

    /**
     * Leave a group.
     */
    public function leave(int $groupId)
    {
        $userId = auth()->id();
        if (!$userId) {
            return redirect()->to('/account/login');
        }

        $groupMembers = new \App\Models\GroupMemberModel();

        // Find the membership record
        $membership = $groupMembers->where('group_id', $groupId)->where('user_id', $userId)->first();
        if ($membership === null) {
            return redirect()->back()->with('error', 'You are not a member of this group.');
        }

        // Prevent group creator from leaving
        $groups = new \App\Models\GroupModel();
        $group = $groups->find($groupId);
        if ($group && $group->creator_id == $userId) {
            return redirect()->back()->with('error', 'As the group creator, you cannot leave the group.');
        }

        // Remove the user from the group
        if ($groupMembers->delete($membership->id) === false) {
            return redirect()->back()->with('error', 'Could not leave the group.');
        }

        return redirect()->to('/groups')->with('message', 'You have left the group.');
    }
}
