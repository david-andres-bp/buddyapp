<?php

namespace App\Libraries;

use CodeIgniter\View\View;
use Config\Services;

class ThemeView extends View
{
    /**
     * Overridden render method to implement theme view fallback.
     *
     * @param string     $view   The view file to render.
     * @param array|null $options An array of options.
     * @param bool|null  $saveData Whether to save data for subsequent calls.
     *
     * @return string The rendered view.
     */
    public function render(string $view, ?array $options = null, ?bool $saveData = null): string
    {
        $theme = Services::theme();
        $themeViewPath = $theme->getViewPath();

        if ($themeViewPath && file_exists($themeViewPath . $view . '.php')) {
            // If the view exists in the theme, render it.
            // The renderer will look in its primary path, so we temporarily set it.
            $originalPath = $this->viewPath;
            $this->viewPath = $themeViewPath;

            $output = parent::render($view, $options, $saveData);

            // Restore the original path
            $this->viewPath = $originalPath;

            return $output;
        }

        // Otherwise, fall back to the default renderer behavior
        return parent::render($view, $options, $saveData);
    }
}
