<?php

namespace App\Controllers;

class Main extends BaseController
{
    public function index()
    {
        // Set the active theme
        service('theme')->setActiveTheme('heartbeat');

        // The ThemeView library will handle looking for this view in the theme's folder first.
        return view('welcome_message');
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
