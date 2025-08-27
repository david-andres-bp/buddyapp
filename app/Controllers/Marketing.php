<?php

namespace App\Controllers;

class Marketing extends BaseController
{
    /**
     * Displays the HeartBeat theme's marketing page.
     */
    public function heartbeat()
    {
        $this->theme->setActiveTheme('heartbeat');
        return view('index');
    }

    /**
     * Displays the Serendipity theme's marketing page.
     */
    public function serendipity()
    {
        $this->theme->setActiveTheme('serendipity');
        return view('index');
    }
}
