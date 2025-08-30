<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        // Load the main discover page for the theme
        return view('discover');
    }

    public function myAccount()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        $user = auth()->user();
        if (!$user) {
            return redirect()->to('/account/login');
        }

        $meta = new \App\Models\UserMetaModel();
        $bio = $meta->where('user_id', $user->id)->where('meta_key', 'bio')->first();

        $data = [
            'user' => $user,
            'bio'  => $bio->meta_value ?? '',
        ];

        return $this->renderThemeView('account/info', $data);
    }

    public function scanHistory()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        return $this->renderThemeView('account/history');
    }

    public function updateProfile()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->to('/account/login');
        }

        $rules = [
            'username' => 'required|alpha_numeric_space|min_length[3]|max_length[30]',
            'email'    => 'required|valid_email',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Update username
        $users = new \CodeIgniter\Shield\Models\UserModel();
        $users->update($user->id, ['username' => $this->request->getPost('username')]);

        // Update email
        $identities = new \CodeIgniter\Shield\Models\UserIdentityModel();
        $identity = $identities->where('user_id', $user->id)->where('type', 'email_password')->first();
        if ($identity) {
            $identities->update($identity->id, ['secret' => $this->request->getPost('email')]);
        }

        return redirect()->back()->with('message', 'Profile updated successfully.');
    }

    public function updateBio()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->to('/account/login');
        }

        $bioContent = $this->request->getPost('bio');

        $meta = new \App\Models\UserMetaModel();
        $existing = $meta->where('user_id', $user->id)->where('meta_key', 'bio')->first();

        if ($existing) {
            $meta->update($existing->id, ['meta_value' => $bioContent]);
        } else {
            $meta->insert([
                'user_id'    => $user->id,
                'meta_key'   => 'bio',
                'meta_value' => $bioContent,
            ]);
        }

        return redirect()->back()->with('message', 'Bio updated successfully.');
    }
}
