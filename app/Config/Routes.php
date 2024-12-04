<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::index');
$routes->post('/login', 'Auth::login');
$routes->get('/logout', 'Auth::logout');


// $routes->group('pengguna',['filter' => 'auth:admin'], static function($routes){
//     $routes->get('', 'Pengguna::index');
//     $routes->get('tambah', 'Pengguna::tambah');
//     $routes->post('save', 'Pengguna::save');
//     $routes->post('saveUserAndPengguna', 'Pengguna::saveUserAndPengguna');
// });

// Grup untuk pengguna
$routes->group('pengguna', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('', 'Pengguna::index'); // Daftar pengguna
    $routes->get('tambah', 'Pengguna::tambah'); // Form tambah pengguna
    $routes->post('save', 'Pengguna::save'); // Simpan pengguna
});

// Grup untuk rekening
$routes->group('rekening', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('tambah', 'Rekening::tambah'); // Form tambah rekening
    $routes->post('save', 'Rekening::save'); // Simpan rekening
});

// Grup untuk transaksi
$routes->group('transaksi', ['filter' => 'auth:admin'], static function ($routes) {
    $routes->get('tambah', 'Transaksi::tambah'); // Form tambah transaksi
    $routes->post('save', 'Transaksi::save'); // Simpan transaksi
});
