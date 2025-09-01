<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        // The global 'theme' filter handles setting the active theme.
        // This method now correctly assumes the theme is set and renders
        // the appropriate discover page for that theme.
        return view('discover');
    }

    public function myAccount()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->to('/account/login');
        }

        return view('account/info', ['user' => $user]);
    }

    public function scanHistory()
    {
        // This is a placeholder for a feature that might not be used
        // in the Serendipity theme, but we provide a view for it.
        return view('account/history');
    }
}
