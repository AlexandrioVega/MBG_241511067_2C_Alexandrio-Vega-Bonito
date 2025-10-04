<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// app/Config/Routes.php
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/login', 'AuthController::attemptLogin');
$routes->get('/logout', 'AuthController::logout');

// Grup untuk Gudang (Admin)
$routes->group('gudang', ['filter' => 'auth:gudang'], function($routes) {
    $routes->get('dashboard', 'GudangController::dashboard');
    $routes->get('bahan', 'GudangController::bahan');
    $routes->get('bahan/create', 'GudangController::create');
    $routes->post('bahan/store', 'GudangController::store'); 
    $routes->get('bahan/edit/(:num)', 'GudangController::edit/$1'); // Menampilkan form edit
    $routes->post('bahan/update/(:num)', 'GudangController::update/$1'); // Memproses update
});

// Grup untuk Dapur (Client)
$routes->group('dapur', ['filter' => 'auth:dapur'], function($routes) {
    $routes->get('dashboard', 'DapurController::dashboard');
});