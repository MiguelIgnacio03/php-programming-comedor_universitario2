<?php
/**
 * Reportes Controller
 */
class Reportes extends Controller {
    
    public function __construct() {
        AuthMiddleware::handle();
        // Only admins can generate reports
        if ($_SESSION['usuario_rol'] !== 'administrador') {
            header('Location: ' . URLROOT . '/dashboard');
            exit;
        }
    }

    public function index() {
        $data = [
            'title' => 'Generador de Reportes'
        ];
        $this->view('reportes/index', $data);
    }

    public function inventario() {
        require_once APPROOT . '/app/core/ReportGenerator.php';
        ReportGenerator::generarReporteInventario();
    }

    public function consumo() {
        $fechaInicio = $_GET['fecha_inicio'] ?? date('Y-m-d', strtotime('-30 days'));
        $fechaFin = $_GET['fecha_fin'] ?? date('Y-m-d');
        
        require_once APPROOT . '/app/core/ReportGenerator.php';
        ReportGenerator::generarReporteConsumo($fechaInicio, $fechaFin);
    }
}
