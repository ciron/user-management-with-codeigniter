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

$routes->get('/dashboard', 'User::dashboard');

$routes->get('/logout', 'User::logout');


$routes->get('/admin/login', 'Auth::adminLogin');

$routes->post('/admin/login/authenticate', 'Auth::adminAuthenticate');

$routes->get('/admin/dashboard', 'Admin::adminDashboard');



$routes->get('/admin/logout', 'Admin::adminLogout');
$routes->get('/admin/getUsers', 'Admin::getUsers');
$routes->get('/admin/getUserById/(:any)', 'Admin::getUserById/$1');
$routes->post('/admin/updateStatus', 'Admin::updateStatus');
