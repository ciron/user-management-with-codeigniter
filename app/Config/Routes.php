<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('signup', 'Auth::signup');
$routes->post('auth/register', 'Auth::register');
$routes->get('login', 'Auth::login');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('logout', 'Auth::logout');

$routes->get('dashboard', 'Dashboard::index');
$routes->get('dashboard/profile', 'Dashboard::profile');
$routes->post('dashboard/updateProfile', 'Dashboard::updateProfile');

$routes->get('admin', 'Admin::index');
$routes->get('admin/getUsers', 'Admin::getUsers');
$routes->post('admin/updateStatus', 'Admin::updateStatus');
