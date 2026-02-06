<?php
/**
 * Dashboard Controller
 */
class Dashboard extends Controller {
    private $productoModel;
    private $loteModel;

    public function __construct() {
        AuthMiddleware::handle(); // Require login
        $this->productoModel = $this->model('ProductoModel');
        $this->loteModel = $this->model('LoteModel');
    }

    public function index() {
        $stockCritico = $this->productoModel->checkStockCritico();
        $lotesProximosVencer = $this->loteModel->getLotesProximosVencer();
        $productos = $this->productoModel->getAllWithDetails();

        // Calcular estadísticas
        $totalProductos = count($productos);
        $productosStockCritico = count($stockCritico);
        $lotesVencenProximo = count($lotesProximosVencer);

        $data = [
            'title' => 'Dashboard - Comedor Universitario',
            'totalProductos' => $totalProductos,
            'productosStockCritico' => $productosStockCritico,
            'lotesVencenProximo' => $lotesVencenProximo,
            'stockCritico' => $stockCritico,
            'lotesProximosVencer' => $lotesProximosVencer
        ];

        $this->view('dashboard/index', $data);
    }
}
