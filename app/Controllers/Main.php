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

        return $this->renderThemeView('account/info', ['user' => $user]);
    }

    public function scanHistory()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        return $this->renderThemeView('account/history');
    }
}
