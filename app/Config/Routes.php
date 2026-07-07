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
    
    // Admin - CRUD Siswa
    $routes->get('/admin/siswa/create', 'Admin::siswaCreate');
    $routes->post('/admin/siswa/store', 'Admin::siswaStore');
    $routes->get('/admin/siswa/edit/(:num)', 'Admin::siswaEdit/$1');
    $routes->post('/admin/siswa/update/(:num)', 'Admin::siswaUpdate/$1');
    $routes->post('/admin/siswa/delete/(:num)', 'Admin::siswaDelete/$1'); // Use POST/DELETE for safety, or direct post
    
    // Admin - CRUD Guru
    $routes->get('/admin/guru/create', 'Admin::guruCreate');
    $routes->post('/admin/guru/store', 'Admin::guruStore');
    $routes->get('/admin/guru/edit/(:num)', 'Admin::guruEdit/$1');
    $routes->post('/admin/guru/update/(:num)', 'Admin::guruUpdate/$1');
    $routes->post('/admin/guru/delete/(:num)', 'Admin::guruDelete/$1');
    
    // Admin - CRUD Mapel
    $routes->get('/admin/mapel/create', 'Admin::mapelCreate');
    $routes->post('/admin/mapel/store', 'Admin::mapelStore');
    $routes->get('/admin/mapel/edit/(:num)', 'Admin::mapelEdit/$1');
    $routes->post('/admin/mapel/update/(:num)', 'Admin::mapelUpdate/$1');
    $routes->post('/admin/mapel/delete/(:num)', 'Admin::mapelDelete/$1');

    // GURU ROUTES
    $routes->get('/guru', 'Guru::index');
    $routes->get('/guru/nilai/edit/(:num)/(:num)', 'Guru::editNilai/$1/$2');
    $routes->post('/guru/nilai/update/(:num)/(:num)', 'Guru::updateNilai/$1/$2');

    // SISWA ROUTES
    $routes->get('/siswa', 'Siswa::index');
    $routes->get('/siswa/profil', 'Siswa::profil');
    $routes->post('/siswa/profil/update', 'Siswa::updateProfil');
});