<?php
/**
 * Home Controller
 */
class Home {
    public function index() {
        $data = [
            'title' => 'Bienvenido al Comedor Universitario',
            'description' => 'Sistema de gestión integral con arquitectura MVC y MVVM.'
        ];
        
        // Load view
        require_once APPROOT . '/app/views/home_view.php';
    }
}
