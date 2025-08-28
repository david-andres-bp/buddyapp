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
    protected array $themes = [];

    public function __construct()
    {
        $this->discoverThemes();
    }

    /**
     * Scans the themes directory and populates the $themes array.
     */
    public function discoverThemes(): void
    {
        $themesPath = FCPATH . 'themes';
        if (!is_dir($themesPath)) {
            return;
        }

        $directories = new \DirectoryIterator($themesPath);

        foreach ($directories as $dir) {
            if ($dir->isDir() && !$dir->isDot()) {
                $themeName = $dir->getBasename();
                $info = $this->getThemeInfo($themeName);
                if ($info) {
                    $this->themes[$themeName] = $info;
                }
            }
        }
    }

    /**
     * Gets the theme.json info for a single theme.
     *
     * @return object|null
     */
    public function getThemeInfo(string $themeName): ?object
    {
        $jsonPath = FCPATH . 'themes/' . $themeName . '/theme.json';

        if (!is_file($jsonPath)) {
            return null;
        }

        $json = file_get_contents($jsonPath);
        $info = json_decode($json);

        return json_last_error() === JSON_ERROR_NONE ? $info : null;
    }

    /**
     * Returns the array of all discovered themes.
     */
    public function getThemes(): array
    {
        return $this->themes;
    }

    /**
     * Sets the active theme for the current request.
     */
    public function setActiveTheme(string $themeName): self
    {
        if (!array_key_exists($themeName, $this->themes)) {
            throw new \InvalidArgumentException("Theme '{$themeName}' not found.");
        }

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
            return '';
        }

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
