<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ThemeFilter implements FilterInterface
{
    /**
     * This is called before the controller is executed.
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Get the active theme from the environment file.
        $activeTheme = env('app.theme');

        // If a theme is defined, set it as active.
        if ($activeTheme) {
            service('theme')->setActiveTheme($activeTheme);
        }
    }

    /**
     * This is called after the controller is executed.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed here.
    }
}
