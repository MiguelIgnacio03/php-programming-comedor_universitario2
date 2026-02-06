<?php
/**
 * Authentication Middleware
 */
class AuthMiddleware {
    /**
     * Protect routes and check roles
     * @param string|null $role Expected role
     */
    public static function handle($role = null) {
        if (!Auth::isLoggedIn()) {
            header('Location: ' . URLROOT . '/login');
            exit;
        }
        
        if ($role && !Auth::checkRole($role)) {
            header('Location: ' . URLROOT . '/acceso-denegado');
            exit;
        }
    }
}
