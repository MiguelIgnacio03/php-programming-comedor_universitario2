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
spl_autoload_register(function($className) {
    if (file_exists(APPROOT . '/app/core/' . $className . '.php')) {
        require_once APPROOT . '/app/core/' . $className . '.php';
    }
});

// Init Core Library (e.g., Router)
$router = new Router();

// Add Routes
$router->add('home', 'Home', 'index');
$router->add('', 'Home', 'index');

// Dispatch Router
$router->dispatch($_SERVER['REQUEST_URI']);
