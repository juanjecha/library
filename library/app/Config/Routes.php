<?php

use CodeIgniter\Router\RouteCollection;
use App\Controllers\BookCartController;
/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('login', 'Auth::index');
$routes->post('login', 'Auth::loginAuth');
$routes->post('register', 'Auth::registerSave');
$routes->get('logout', 'Auth::logout');
// Rutas con middleware de sesion
$routes->group('', ['filter' => 'authFilter'], function($routes) {
$routes->get('dashboard', 'BookCartController::index');
});

$routes->get('libreria/catalogo', [BookCartController::class, 'index']);
$routes->post('libreria/carrito/agregar', [BookCartController::class, 'add']);
$routes->get('libreria/carrito', [BookCartController::class, 'show']);
$routes->get('libreria/carrito/eliminar/(:segment)', [BookCartController::class, 'remove']);
$routes->get('libreria/carrito/vaciar', [BookCartController::class, 'clear']);


    // registros
    $routes->post('save_aut', 'AuthorController::new');
    $routes->post('save_ed', 'EditorialController::new');
    $routes->post('save_book', 'BookController::new');

    // edits
    $routes->post('edit_aut/(:num)', 'AuthorController::update/$1');
    $routes->post('edit_ed/(:num)', 'EditorialController::update/$1');
    $routes->post('edit_book/(:num)', 'BookController::update/$1');


$routes->post('search', 'Home::filt');