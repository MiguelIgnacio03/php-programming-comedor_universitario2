<?php
/**
 * Authentication Helper Class
 */
class Auth {
    /**
     * Start session if not already started
     */
    private static function initSession() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Login logic
     */
    public static function login($email, $password) {
        self::initSession();
        
        // Ensure UsuarioModel is loaded
        if (!class_exists('UsuarioModel')) {
            require_once APPROOT . '/app/models/UsuarioModel.php';
        }

        $userModel = new UsuarioModel();
        $usuario = $userModel->findByEmail($email);
        
        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_rol'] = $usuario['rol'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            return true;
        }

        return false;
    }
    
    /**
     * Logout logic
     */
    public static function logout() {
        self::initSession();
        session_unset();
        session_destroy();
    }

    /**
     * Check if user is logged in
     */
    public static function isLoggedIn() {
        self::initSession();
        return isset($_SESSION['usuario_id']);
    }

    /**
     * Check if user has a specific role
     */
    public static function checkRole($role) {
        self::initSession();
        return isset($_SESSION['usuario_rol']) && $_SESSION['usuario_rol'] === $role;
    }
}
