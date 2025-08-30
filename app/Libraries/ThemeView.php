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
        $theme         = Services::theme();
        $themeViewPath = $theme->getViewPath();
        $originalPath  = $this->viewPath;

        // If a theme is active and the view exists in the theme's path,
        // set the view path to the theme's directory for this render call.
        if ($themeViewPath && file_exists($themeViewPath . $view . '.php')) {
            $this->viewPath = $themeViewPath;
        }

        // The saveData parameter should default to true, to match the parent
        // and the behavior of the `view()` helper function.
        $output = parent::render($view, $options, $saveData ?? true);

        // Restore the original view path
        $this->viewPath = $originalPath;

        return $output;
    }
}
