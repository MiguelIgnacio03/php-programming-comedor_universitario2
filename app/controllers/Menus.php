<?php
/**
 * Menus Controller
 */
class Menus extends Controller {
    private $menuModel;
    private $productoModel;

    public function __construct() {
        AuthMiddleware::handle(); // Require login
        $this->menuModel = $this->model('MenuModel');
        $this->productoModel = $this->model('ProductoModel');
    }

    public function index() {
        $menus = $this->menuModel->getAllWithDetails();

        $data = [
            'title' => 'Planificación de Menús',
            'menus' => $menus
        ];

        $this->view('menus/index', $data);
    }

    public function crear() {
        $productos = $this->productoModel->getAllWithDetails();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menuData = [
                'nombre' => trim($_POST['nombre']),
                'dia_semana' => $_POST['dia_semana'],
                'tipo' => $_POST['tipo'],
                'descripcion' => trim($_POST['descripcion']),
                'fecha' => $_POST['fecha'],
                'activo' => 1
            ];

            $menuId = $this->menuModel->create($menuData);
            if ($menuId) {

                // Add products to menu
                if (isset($_POST['productos']) && is_array($_POST['productos'])) {
                    foreach ($_POST['productos'] as $productoId => $cantidad) {
                        if ($cantidad > 0) {
                            $this->menuModel->addProducto($menuId, $productoId, $cantidad);
                        }
                    }
                }

                header('Location: ' . URLROOT . '/menus');
                exit;
            }
        }

        $data = [
            'title' => 'Crear Menú',
            'productos' => $productos
        ];

        $this->view('menus/crear', $data);
    }

    public function consumir($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $result = $this->menuModel->consumirMenu($id, $_SESSION['usuario_id']);
            
            // Store result in session for display
            $_SESSION['menu_consumo_result'] = $result;
            
            header('Location: ' . URLROOT . '/menus');
            exit;
        }
    }
}
