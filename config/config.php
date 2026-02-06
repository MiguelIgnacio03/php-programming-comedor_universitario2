<?php
/**
 * App Configuration
 */

// DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'comedor_universitario');

// App Root
if (!defined('APPROOT')) {
    define('APPROOT', dirname(dirname(__FILE__)));
}

// URL Root (Dynamic detection)
if (!isset($_SERVER['HTTP_HOST'])) {
    define('URLROOT', 'http://localhost/Comedor_Universitario');
} else {
    $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') ? "https" : "http";
    $host = $_SERVER['HTTP_HOST'];
    $projectFolder = str_replace('/public', '', dirname($_SERVER['PHP_SELF']));
    define('URLROOT', "$protocol://$host" . ($projectFolder === '/' ? '' : $projectFolder));
}

// Site Name
define('SITENAME', 'Comedor Universitario');

// App Version
define('APPVERSION', '1.0.0');
