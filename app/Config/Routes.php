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
