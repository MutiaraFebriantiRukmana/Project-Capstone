<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');


$routes->get('dashboard', function() {
    if(!session()->get('isLogged')) return redirect()->to('/');
    return view('dashboard/dashboard'); 
});
