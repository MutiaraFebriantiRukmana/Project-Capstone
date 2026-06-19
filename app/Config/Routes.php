<?php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */

$routes->get('/', 'Auth::index');
$routes->post('auth/login', 'Auth::login');
$routes->get('auth/logout', 'Auth::logout');
$routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->group('owner', ['filter' => 'auth'], function($routes) {
    $routes->get('master-barang', 'Pembelian::index');
    $routes->post('master-barang/save', 'Pembelian::save');
    $routes->get('detail-barang', 'Pembelian::detail');
    $routes->get('barang-keluar', 'Penjualan::index');
    $routes->get('analisis', 'Analisis::index');
    $routes->get('laporan', 'Laporan::index');
    $routes->get('laporan/cetak', 'Laporan::cetak');
});

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('stok-barang', 'Stok::index');
    $routes->get('barang-keluar', 'Penjualan::index');
    $routes->post('barang-keluar/save', 'Penjualan::save');
    $routes->get('laporan', 'Laporan::index');
    $routes->get('laporan/cetak', 'Laporan::cetak');
});