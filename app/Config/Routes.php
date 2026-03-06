<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/signup', 'Auth::signup');
$routes->post('/signup/register', 'Auth::register');
$routes->get('/login', 'Auth::login');
$routes->post('/login/authenticate', 'Auth::authenticate');

// User routes
$routes->group('user', function($routes){
    $routes->get('dashboard', 'User::dashboard');
    $routes->get('profile', 'User::profile');
    $routes->post('updateProfile', 'User::updateProfile');
    $routes->get('logout', 'User::logout');
});

// Admin routes
$routes->group('admin', function($routes){
    $routes->get('login', 'Auth::adminLogin');
    $routes->post('login/authenticate', 'Auth::adminAuthenticate');

    $routes->get('dashboard', 'Admin::adminDashboard');
    $routes->get('logout', 'Admin::adminLogout');
    $routes->get('userlist', 'Admin::userlist');
    $routes->get('getUsers', 'Admin::getUsers');
    $routes->get('getUserById/(:any)', 'Admin::getUserById/$1');
    $routes->post('updateStatus', 'Admin::updateStatus');
});