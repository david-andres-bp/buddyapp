<?php

namespace App\Libraries;

/**
 * A simple service to manage the active theme.
 * It holds the theme's name and provides helper methods.
 * The core view rendering logic is handled by the custom View service.
 */
class Theme
{
    protected ?string $activeTheme = null;

    /**
     * Sets the active theme for the current request.
     */
    public function setActiveTheme(string $themeName): self
    {
        $this->activeTheme = $themeName;

        return $this;
    }

    /**
     * Gets the name of the active theme.
     */
    public function getActiveTheme(): ?string
    {
        return $this->activeTheme;
    }

    /**
     * Generates a URL to an asset within the active theme's public directory.
     *
     * @param string $path The relative path to the asset (e.g., 'css/style.css').
     */
    public function asset(string $path): string
    {
        if (!$this->activeTheme) {
            // In a real app, you might want to throw an exception or handle this differently.
            return '';
        }

        // Ensure the URL helper is loaded
        helper('url');

        return base_url('themes/' . $this->activeTheme . '/' . ltrim($path, '/'));
    }

    /**
     * Gets the file path to the Views directory for the active theme.
     */
    public function getViewPath(): ?string
    {
        if (!$this->activeTheme) {
            return null;
        }

        return FCPATH . 'themes/' . $this->activeTheme . '/Views/';
    }
}
