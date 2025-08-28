<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/**
 * @var RouteCollection $routes
 */
$routes = service('routes');

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Main::index');

// Theme Marketing Pages
$routes->get('/apps/heartbeat', 'Marketing::heartbeat');
$routes->get('/apps/serendipity', 'Marketing::serendipity');

/*
 * --------------------------------------------------------------------
 * API Routes
 * --------------------------------------------------------------------
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    // Public routes - no authentication required
    $routes->post('register', 'Auth::register');
    $routes->post('login', 'Auth::login');
    $routes->get('tiers', 'Tiers::index');
    $routes->post('analyze', 'Analysis::create');

    // Protected routes - require JWT authentication
    $routes->group('', ['filter' => 'jwt'], function ($routes) {
        $routes->get('profile', 'Auth::profile');
        $routes->put('membership', 'Auth::upgradeMembership');

        // Additional protected routes can be added here
        $routes->get('dashboard', 'Dashboard::index');
        $routes->get('analytics', 'Analytics::index');
        $routes->post('logout', 'Auth::logout');
    });
});

$routes->group('account', ['namespace' => 'App\Controllers'], function ($routes) {
    $routes->get('login', 'Login::index');
    $routes->get('signup', 'Login::signup');
    $routes->get('/', 'Main::index');
    $routes->get('info', 'Main::myAccount');
    $routes->get('history', 'Main::scanHistory');
});


