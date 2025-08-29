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
$routes->get('/', 'DiscoverController::index', ['filter' => 'session']);

// Theme Marketing Pages
$routes->get('/apps/heartbeat', 'Marketing::heartbeat');
$routes->get('/apps/serendipity', 'Marketing::serendipity');

// Profile Page
$routes->get('/profile/(:segment)', 'ProfileController::show/$1');

// Connections
$routes->get('/connections', 'ConnectionController::index', ['filter' => 'session']);
$routes->post('/connect/create/(:num)', 'ConnectionController::create/$1', ['filter' => 'session']);
$routes->post('/connect/accept/(:num)', 'ConnectionController::accept/$1', ['filter' => 'session']);
$routes->post('/connect/decline/(:num)', 'ConnectionController::decline/$1', ['filter' => 'session']);

// Groups
$routes->get('/groups', 'GroupController::index', ['filter' => 'session']);
$routes->get('/groups/new', 'GroupController::new', ['filter' => 'session']);
$routes->post('/groups/create', 'GroupController::create', ['filter' => 'session']);
$routes->get('/groups/(:segment)', 'GroupController::show/$1', ['filter' => 'session']);
$routes->post('/groups/join/(:num)', 'GroupController::join/$1', ['filter' => 'session']);
$routes->post('/groups/leave/(:num)', 'GroupController::leave/$1', ['filter' => 'session']);

// Messages
$routes->get('/messages', 'MessageController::index', ['filter' => 'session']);
$routes->get('/messages/new', 'MessageController::new', ['filter' => 'session']);
$routes->post('/messages/create', 'MessageController::create', ['filter' => 'session']);
$routes->get('/messages/(:num)', 'MessageController::show/$1', ['filter' => 'session']);
$routes->post('/messages/reply/(:num)', 'MessageController::reply/$1', ['filter' => 'session']);

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

    // Session-protected API routes
    $routes->group('', ['filter' => 'session'], function ($routes) {
        $routes->post('activities', 'ActivityController::create');
    });
});

$routes->group('account', ['namespace' => 'App\Controllers'], function ($routes) {
    // Shield routes
    $routes->get('login', '\CodeIgniter\Shield\Controllers\LoginController::loginView', ['as' => 'login', 'filter' => 'theme']);
    $routes->post('login', '\CodeIgniter\Shield\Controllers\LoginController::loginAction');
    $routes->get('signup', '\CodeIgniter\Shield\Controllers\RegisterController::registerView', ['as' => 'register', 'filter' => 'theme']);
    $routes->post('signup', '\CodeIgniter\Shield\Controllers\RegisterController::registerAction');
    $routes->get('logout', '\CodeIgniter\Shield\Controllers\LoginController::logoutAction', ['as' => 'logout']);

    // Custom account routes
    $routes->get('/', 'Main::index');
    $routes->get('info', 'Main::myAccount', ['filter' => 'session']);
    $routes->get('history', 'Main::scanHistory', ['filter' => 'session']);
});


