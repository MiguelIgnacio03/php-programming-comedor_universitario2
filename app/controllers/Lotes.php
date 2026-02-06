<?php
/**
 * Lotes Controller
 */
class Lotes extends Controller {
    private $loteModel;
    private $productoModel;
    private $movimientoModel;

    public function __construct() {
        AuthMiddleware::handle(); // Require login
        $this->loteModel = $this->model('LoteModel');
        $this->productoModel = $this->model('ProductoModel');
        $this->movimientoModel = $this->model('MovimientoModel');
    }

    public function index() {
        $lotes = $this->loteModel->getAllWithDetails();
        $lotesProximosVencer = $this->loteModel->getLotesProximosVencer();

        $data = [
            'title' => 'Gestión de Lotes',
            'lotes' => $lotes,
            'lotesProximosVencer' => $lotesProximosVencer
        ];

        $this->view('lotes/index', $data);
    }

    public function crear() {
        $productos = $this->productoModel->getAllWithDetails();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'producto_id' => $_POST['producto_id'],
                'numero_lote' => trim($_POST['numero_lote']),
                'cantidad' => $_POST['cantidad'],
                'fecha_ingreso' => $_POST['fecha_ingreso'],
                'fecha_caducidad' => $_POST['fecha_caducidad'],
                'ubicacion' => trim($_POST['ubicacion'])
            ];

            $loteId = $this->loteModel->create($data);
            if ($loteId) {
                // Registrar movimiento de entrada
                $this->movimientoModel->registrarEntrada(
                    $data['producto_id'],
                    $loteId,
                    $data['cantidad'],
                    $_SESSION['usuario_id'],
                    'Ingreso de nuevo lote'
                );

                header('Location: ' . URLROOT . '/lotes');
                exit;
            }
        }

        $data = [
            'title' => 'Registrar Lote',
            'productos' => $productos
        ];

        $this->view('lotes/crear', $data);
    }

    public function editar($id) {
        $lote = $this->loteModel->getById($id);
        $productos = $this->productoModel->getAllWithDetails();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'producto_id' => $_POST['producto_id'],
                'numero_lote' => trim($_POST['numero_lote']),
                'cantidad' => $_POST['cantidad'],
                'fecha_ingreso' => $_POST['fecha_ingreso'],
                'fecha_caducidad' => $_POST['fecha_caducidad'],
                'ubicacion' => trim($_POST['ubicacion'])
            ];

            if ($this->loteModel->update($data)) {
                
                // Optional: Register adjustment movement? 
                // For now just update.
                
                header('Location: ' . URLROOT . '/lotes');
                exit;
            }
        }

        $data = [
            'title' => 'Editar Lote',
            'lote' => $lote,
            'productos' => $productos
        ];

        $this->view('lotes/editar', $data);
    }

    public function deshabilitar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->loteModel->disable($id)) {
                header('Location: ' . URLROOT . '/lotes');
                exit;
            }
        }
    }

    public function inactivos() {
        $lotes = $this->loteModel->getInactive();

        $data = [
            'title' => 'Lotes Deshabilitados',
            'lotes' => $lotes
        ];

        $this->view('lotes/inactivos', $data);
    }

    public function activar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->loteModel->activate($id)) {
                header('Location: ' . URLROOT . '/lotes/inactivos');
                exit;
            }
        }
    }
}
