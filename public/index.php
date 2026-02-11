<?php
/**
 * Main Entry Point
 */

// Load Config
require_once dirname(dirname(__FILE__)) . '/config/config.php';

// Basic error reporting - Disable in production
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Autoload Core Libraries
// Autoload Core Libraries, Models and Controllers
spl_autoload_register(function($className) {
    // Directories to search
    $directories = [
        APPROOT . '/app/core/',
        APPROOT . '/app/models/',
        APPROOT . '/app/controllers/'
    ];

    foreach ($directories as $directory) {
        if (file_exists($directory . $className . '.php')) {
            require_once $directory . $className . '.php';
            return;
        }
    }
});

// Init Core Library (e.g., Router)
$router = new Router();

// Add Routes
$router->add('api/dashboard', 'Api', 'dashboard');
$router->add('api/productos', 'Api', 'productos');
$router->add('api/lotes', 'Api', 'lotes');
$router->add('api/consumir', 'Api', 'consumir');
// $router->add('api', 'Api', 'index');

$router->add('dashboard', 'Dashboard', 'index');
$router->add('categorias', 'Categorias', 'index');
$router->add('categorias/inactivos', 'Categorias', 'inactivos');
$router->add('categorias/crear', 'Categorias', 'crear');
$router->add('categorias/editar', 'Categorias', 'editar');
$router->add('categorias/deshabilitar', 'Categorias', 'deshabilitar');
$router->add('categorias/activar', 'Categorias', 'activar');
$router->add('productos', 'Productos', 'index');
$router->add('productos/crear', 'Productos', 'crear');
$router->add('productos/editar', 'Productos', 'editar');
$router->add('productos/deshabilitar', 'Productos', 'deshabilitar');
$router->add('productos/inactivos', 'Productos', 'inactivos');
$router->add('productos/activar', 'Productos', 'activar');
$router->add('lotes', 'Lotes', 'index');
$router->add('lotes/crear', 'Lotes', 'crear');
$router->add('lotes/editar', 'Lotes', 'editar');
$router->add('lotes/deshabilitar', 'Lotes', 'deshabilitar');
$router->add('lotes/inactivos', 'Lotes', 'inactivos');
$router->add('lotes/activar', 'Lotes', 'activar');
$router->add('menus', 'Menus', 'index');
$router->add('menus/crear', 'Menus', 'crear');
$router->add('menus/editar', 'Menus', 'editar');
$router->add('menus/consumir', 'Menus', 'consumir');

$router->add('proveedores', 'Proveedores', 'index');
$router->add('proveedores/crear', 'Proveedores', 'crear');
$router->add('proveedores/editar', 'Proveedores', 'editar');
$router->add('proveedores/eliminar', 'Proveedores', 'eliminar');
$router->add('proveedores/inactivos', 'Proveedores', 'inactivos');
$router->add('proveedores/activar', 'Proveedores', 'activar');

$router->add('reportes', 'Reportes', 'index');
$router->add('reportes/inventario', 'Reportes', 'inventario');
$router->add('reportes/consumo', 'Reportes', 'consumo');
$router->add('home', 'Home', 'index');
$router->add('login', 'Login', 'index');
$router->add('logout', 'Login', 'logout');
$router->add('', 'Login', 'index'); // Default to login

// Dispatch Router
$router->dispatch($_SERVER['REQUEST_URI']);
