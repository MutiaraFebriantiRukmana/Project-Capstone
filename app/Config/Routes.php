<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');

// Route Owner 
$routes->group('owner', ['filter' => 'auth'], function($routes) {
    $routes->get('barang-masuk', 'BarangMasuk::index'); 
    $routes->post('barang-masuk/save', 'BarangMasuk::save');
    $routes->post('barang-masuk/update/(:num)', 'BarangMasuk::update/$1');
    $routes->get('barang-masuk/delete/(:num)', 'BarangMasuk::delete/$1');
    $routes->get('laporan-penjualan', 'Laporan::index');
    $routes->get('barang-keluar', 'BarangKeluar::index');
});

// Route Admin 
$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('stok-barang', 'StokBarang::index'); 
    $routes->get('laporan', 'Laporan::index');
    $routes->post('laporan/save', 'Laporan::save');
    $routes->get('laporan', 'Laporan::index');
    $routes->post('laporan/save', 'Laporan::save');
    $routes->post('laporan/update/(:num)', 'Laporan::update/$1');
    $routes->get('laporan/delete/(:num)', 'Laporan::delete/$1');
});

$routes->get('dashboard', function() {
    if(!session()->get('isLogged')) return redirect()->to('/');
    return view('dashboard/dashboard'); 
});
