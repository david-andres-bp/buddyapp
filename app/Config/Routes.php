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

// Get the active theme from the environment file.
$activeTheme = env('app.theme');

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
// Marketing and common pages that are not theme-dependent
$routes->get('/apps/heartbeat', 'Marketing::heartbeat');
$routes->get('/apps/serendipity', 'Marketing::serendipity');

// --- Globally Available Routes ---
// Profile pages are available on all themes.
$routes->get('/profile/(:segment)', 'ProfileController::show/$1', ['as' => 'profile']);

// --- Theme-Specific Routes ---

// Set the home route based on the active theme.
switch ($activeTheme) {
    case 'heartbeat':
        $routes->get('/', 'DiscoverController::index', ['as' => 'home', 'filter' => 'session']);
        break;
    case 'serendipity':
        $routes->get('/', 'DiscoverController::index', ['as' => 'home', 'filter' => 'session']);
        break;
    case 'connectsphere':
        $routes->get('/', 'GroupController::index', ['as' => 'home', 'filter' => 'session']);
        break;
    default:
        // Fallback for any other case (null, empty, or unknown theme)
        $routes->get('/', 'Home::index', ['as' => 'home']);
        break;
}

// Routes shared by dating themes (HeartBeat & Serendipity)
if (in_array($activeTheme, ['heartbeat', 'serendipity'])) {
    // Feed
    $routes->get('feed', 'FeedController::index', ['as' => 'feed', 'filter' => 'session']);

    // Connections
    $routes->group('connections', ['filter' => 'session'], function ($routes) {
        $routes->get('/', 'ConnectionController::index', ['as' => 'connections']);
        $routes->post('create/(:num)', 'ConnectionController::create/$1', ['as' => 'connection-create']);
        $routes->post('accept/(:num)', 'ConnectionController::accept/$1', ['as' => 'connection-accept']);
        $routes->post('decline/(:num)', 'ConnectionController::decline/$1', ['as' => 'connection-decline']);
    });

    // Messages
    $routes->group('messages', ['filter' => 'session'], function ($routes) {
        $routes->get('/', 'MessageController::index', ['as' => 'messages']);
        $routes->get('new', 'MessageController::new', ['as' => 'message-new']);
        $routes->post('create', 'MessageController::create', ['as' => 'message-create']);
        $routes->get('(:num)', 'MessageController::show/$1', ['as' => 'message-show']);
        $routes->post('reply/(:num)', 'MessageController::reply/$1', ['as' => 'message-reply']);
    });
}

// Routes for ConnectSphere
if ($activeTheme === 'connectsphere') {
    // Groups
    $routes->group('groups', ['filter' => 'session'], function ($routes) {
        $routes->get('/', 'GroupController::index', ['as' => 'groups']);
        $routes->get('new', 'GroupController::new', ['as' => 'group-new']);
        $routes->post('create', 'GroupController::create');
        $routes->get('(:segment)', 'GroupController::show/$1', ['as' => 'group-show']);
        $routes->post('join/(:num)', 'GroupController::join/$1');
        $routes->post('leave/(:num)', 'GroupController::leave/$1');
    });
}

/*
 * --------------------------------------------------------------------
 * API Routes
 * --------------------------------------------------------------------
 */
$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) use ($activeTheme) {
    // Public routes - no authentication required
    $routes->post('register', 'Auth::register');
    $routes->post('login', 'Auth::login');
    $routes->get('tiers', 'Tiers::index');

    if ($activeTheme === 'heartbeat') {
        $routes->post('analyze', 'Analysis::create');
    }

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
    $routes->group('', ['filter' => 'session'], function ($routes) use ($activeTheme) {
        if ($activeTheme === 'heartbeat') {
            $routes->post('activities', 'ActivityController::create', ['as' => 'api-activities']);
        }
    });
});

$routes->group('account', ['namespace' => 'App\Controllers'], function ($routes) {
    // Shield routes
    $routes->get('login', '\CodeIgniter\Shield\Controllers\LoginController::loginView', ['as' => 'login', 'filter' => 'theme']);
    $routes->post('login', '\CodeIgniter\Shield\Controllers\LoginController::loginAction');
    $routes->get('logout', '\CodeIgniter\Shield\Controllers\LoginController::logoutAction', ['as' => 'logout']);

    // Magic Link
    $routes->get('login/magic-link', '\CodeIgniter\Shield\Controllers\MagicLinkController::loginView', ['as' => 'magic-link']);
    $routes->post('login/magic-link', '\CodeIgniter\Shield\Controllers\MagicLinkController::loginAction');
    $routes->get('login/verify-magic-link', '\CodeIgniter\Shield\Controllers\MagicLinkController::verify');

    // Registration
    $routes->get('signup', '\CodeIgniter\Shield\Controllers\RegisterController::registerView', ['as' => 'register', 'filter' => 'theme']);
    $routes->post('signup', '\CodeIgniter\Shield\Controllers\RegisterController::registerAction');

    // Custom account routes
    $routes->get('/', 'Main::index');
    $routes->get('info', 'Main::myAccount', ['as' => 'account-info', 'filter' => 'session']);
    $routes->get('history', 'Main::scanHistory', ['filter' => 'session']);
});


