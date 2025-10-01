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
    $routes->get('gudang/bahan', 'GudangController::bahan');
});

// Grup untuk Dapur (Client)
$routes->group('dapur', ['filter' => 'auth:dapur'], function($routes) {
    $routes->get('dashboard', 'DapurController::dashboard');
});