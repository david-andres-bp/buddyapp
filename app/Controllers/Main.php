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

        // Placeholder for user account page
        return '<h1>My Account Page</h1>';
    }

    public function scanHistory()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        // Placeholder for scan history page
        return '<h1>Scan History Page</h1>';
    }
}
