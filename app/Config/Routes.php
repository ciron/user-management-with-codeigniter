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

$routes->get('/dashboard', 'Auth::dashboard');

$routes->get('/logout', 'Auth::logout');


$routes->get('/admin/login', 'Auth::adminLogin');

$routes->post('/admin/login/authenticate', 'Auth::adminAuthenticate');

$routes->get('/admin/dashboard', 'Auth::adminDashboard');



$routes->get('/admin/logout', 'Auth::adminLogout');
$routes->get('/admin/getUsers', 'Auth::getUsers');
$routes->post('/admin/updateStatus', 'Auth::updateStatus');
