<?php

namespace App\Libraries;

use CodeIgniter\View\View;
use Config\Services;

class ThemeView extends View
{
    /**
     * Overridden render method to implement theme view fallback.
     *
     * This method checks if a view exists in the active theme's
     * directory. If it does, it sets the primary view path to that
     * theme's directory for the remainder of the request. This ensures
     * that not only the initial view but also any views extended via
     * `extend()` are loaded from the theme directory.
     */
    public function render(string $view, ?array $options = null, ?bool $saveData = null): string
    {
        $theme = Services::theme();
        $themeViewPath = $theme->getViewPath();

        // If a theme is active and the view exists in the theme's path,
        // set the view path to the theme's directory.
        if ($themeViewPath && file_exists($themeViewPath . $view . '.php')) {
            $this->viewPath = $themeViewPath;
        }

        // Now, render the view. If the viewPath was changed, the parent
        // renderer will now look in the theme's directory. If not, it
        // will use the default app/Views directory.
        return parent::render($view, $options, $saveData);
    }
}
