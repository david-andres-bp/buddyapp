<?php

namespace App\Libraries;

use CodeIgniter\View\View;
use Config\Services;

class ThemeView extends View
{
    /**
     * Overridden constructor to add our theme's view path to the
     * CodeIgniter FileLocator.
     */
    public function __construct(object $config, ?string $viewPath = null, $loader = null, ?bool $debug = null, ?object $logger = null)
    {
        parent::__construct($config, $viewPath, $loader, $debug, $logger);

        // If a theme is active, add its Views path to the locator.
        // This makes it so the system can find views in the theme's
        // directory, which is critical for the extend() method to work.
        if (service('theme')->getActiveTheme()) {
            $this->loader->addPath(service('theme')->getViewPath());
        }
    }
}
