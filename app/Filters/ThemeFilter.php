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
        // For now, we'll hardcode the theme.
        // In a more complex app, this could be dynamic.
        service('theme')->setActiveTheme('heartbeat');
    }

    /**
     * This is called after the controller is executed.
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No action needed here.
    }
}
