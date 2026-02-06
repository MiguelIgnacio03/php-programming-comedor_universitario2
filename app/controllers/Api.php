<?php
/**
 * API Controller
 * Handles JSON responses for Client-Side rendering (MVVM)
 */
class Api extends Controller {
    private $productoModel;
    private $loteModel;
    private $categoriaModel;

    public function __construct() {
        // Enforce JSON content type
        header('Content-Type: application/json');
        
        // Simple auth check for API
        if (!Auth::isLoggedIn()) {
            http_response_code(401);
            echo json_encode(['error' => 'Unauthorized']);
            exit;
        }

        $this->productoModel = $this->model('ProductoModel');
        $this->loteModel = $this->model('LoteModel');
        $this->categoriaModel = $this->model('CategoriaModel');
    }

    /**
     * Get Dashboard Stats
     * GET /api/dashboard
     */
    public function dashboard() {
        try {
            $stockCritico = $this->productoModel->checkStockCritico();
            $lotesProximosVencer = $this->loteModel->getLotesProximosVencer();
            $productos = $this->productoModel->getAllWithDetails();

            echo json_encode([
                'stats' => [
                    'total_productos' => count($productos),
                    'stock_critico' => count($stockCritico),
                    'lotes_vencen' => count($lotesProximosVencer)
                ],
                'stock_critico_list' => $stockCritico,
                'lotes_vencen_list' => $lotesProximosVencer
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Get All Products
     * GET /api/productos
     */
    public function productos() {
        $productos = $this->productoModel->getAllWithDetails();
        echo json_encode($productos);
    }

    /**
     * Get All Lotes
     * GET /api/lotes
     */
    public function lotes() {
        $lotes = $this->loteModel->getAllWithDetails();
        echo json_encode($lotes);
    }

    /**
     * Consumir API Endpoint (For MVVM actions)
     * POST /api/consumir
     */
    public function consumir() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['error' => 'Method Not Allowed']);
            return;
        }

        $data = json_decode(file_get_contents('php://input'), true);
        
        // Basic validation
        if (!isset($data['producto_id']) || !isset($data['cantidad'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Missing required fields']);
            return;
        }

        require_once APPROOT . '/app/models/ControlCaducidad.php';
        $controlCaducidad = new ControlCaducidad();
        
        $result = $controlCaducidad->consumirPorFIFO(
            $data['producto_id'],
            $data['cantidad'],
            $_SESSION['usuario_id'],
            'Consumo API MVVM'
        );

        echo json_encode($result);
    }
}
