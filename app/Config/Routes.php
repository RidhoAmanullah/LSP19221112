<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login/process', 'Auth::loginProcess');
$routes->get('/register', 'Auth::register');
$routes->post('/register/process', 'Auth::registerProcess');
$routes->get('/logout', 'Auth::logout');

// Protected Routes (Must Login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    
    // ADMIN ROUTES
    $routes->get('/admin', 'Admin::index');
    
    // Admin - CRUD Calon Mahasiswa
    $routes->get('/admin/calon/create', 'Admin::calonCreate');
    $routes->post('/admin/calon/store', 'Admin::calonStore');
    $routes->get('/admin/calon/edit/(:num)', 'Admin::calonEdit/$1');
    $routes->post('/admin/calon/update/(:num)', 'Admin::calonUpdate/$1');
    $routes->post('/admin/calon/delete/(:num)', 'Admin::calonDelete/$1');
    
    // Admin - CRUD Penguji
    $routes->get('/admin/penguji/create', 'Admin::pengujiCreate');
    $routes->post('/admin/penguji/store', 'Admin::pengujiStore');
    $routes->get('/admin/penguji/edit/(:num)', 'Admin::pengujiEdit/$1');
    $routes->post('/admin/penguji/update/(:num)', 'Admin::pengujiUpdate/$1');
    $routes->post('/admin/penguji/delete/(:num)', 'Admin::pengujiDelete/$1');
    
    // Admin - CRUD Prodi
    $routes->get('/admin/prodi/create', 'Admin::prodiCreate');
    $routes->post('/admin/prodi/store', 'Admin::prodiStore');
    $routes->get('/admin/prodi/edit/(:num)', 'Admin::prodiEdit/$1');
    $routes->post('/admin/prodi/update/(:num)', 'Admin::prodiUpdate/$1');
    $routes->post('/admin/prodi/delete/(:num)', 'Admin::prodiDelete/$1');

    // PENGUJI ROUTES
    $routes->get('/penguji', 'Penguji::index');
    $routes->get('/penguji/nilai/edit/(:num)/(:num)', 'Penguji::editNilai/$1/$2');
    $routes->post('/penguji/nilai/update/(:num)/(:num)', 'Penguji::updateNilai/$1/$2');

    // CALON MAHASISWA ROUTES
    $routes->get('/calon', 'Calon::index');
    $routes->get('/calon/profil', 'Calon::profil');
    $routes->post('/calon/profil/update', 'Calon::updateProfil');
});