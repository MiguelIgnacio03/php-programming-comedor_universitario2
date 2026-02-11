<?php
/**
 * Productos Controller
 */
class Productos extends Controller {
    private $productoModel;
    private $categoriaModel;
    private $proveedorModel;

    public function __construct() {
        AuthMiddleware::handle(); // Require login
        $this->productoModel = $this->model('ProductoModel');
        $this->categoriaModel = $this->model('CategoriaModel');
        $this->proveedorModel = $this->model('ProveedorModel');
    }

    public function index() {
        $productos = $this->productoModel->getAllWithDetails();
        $stockCritico = $this->productoModel->checkStockCritico();

        $data = [
            'title' => 'Gestión de Productos',
            'productos' => $productos,
            'stockCritico' => $stockCritico
        ];

        $this->view('productos/index', $data);
    }

    public function crear() {
        $categorias = $this->categoriaModel->getAll();
        $proveedores = $this->proveedorModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nombre' => trim($_POST['nombre']),
                'categoria_id' => $_POST['categoria_id'],
                'unidad_medida' => $_POST['unidad_medida'],
                'stock_minimo' => $_POST['stock_minimo'],
                'stock_maximo' => $_POST['stock_maximo'],
                'precio_unitario' => $_POST['precio_unitario'],
                'proveedor_id' => $_POST['proveedor_id']
            ];

            if (!empty($data['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $data['nombre'])) {
                $data['error'] = 'El nombre del producto solo puede contener letras y espacios';
                $data['categorias'] = $categorias;
                $data['proveedores'] = $proveedores;
                $this->view('productos/crear', $data);
                return;
            }

            if ($this->productoModel->create($data)) {
                header('Location: ' . URLROOT . '/productos');
                exit;
            }
        }

        $data = [
            'title' => 'Crear Producto',
            'categorias' => $categorias,
            'proveedores' => $proveedores
        ];

        $this->view('productos/crear', $data);
    }
    public function editar($id) {
        $producto = $this->productoModel->getById($id);
        $categorias = $this->categoriaModel->getAll();
        $proveedores = $this->proveedorModel->getAll();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'id' => $id,
                'nombre' => trim($_POST['nombre']),
                'categoria_id' => $_POST['categoria_id'],
                'unidad_medida' => $_POST['unidad_medida'],
                'stock_minimo' => $_POST['stock_minimo'],
                'stock_maximo' => $_POST['stock_maximo'],
                'precio_unitario' => $_POST['precio_unitario'],
                'proveedor_id' => $_POST['proveedor_id']
            ];

            if (!empty($data['nombre']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $data['nombre'])) {
                $data['error'] = 'El nombre del producto solo puede contener letras y espacios';
                $data['producto'] = $producto;
                $data['categorias'] = $categorias;
                $data['proveedores'] = $proveedores;
                $this->view('productos/editar', $data);
                return;
            }

            if ($this->productoModel->update($data)) {
                header('Location: ' . URLROOT . '/productos');
                exit;
            }
        }

        $data = [
            'title' => 'Editar Producto',
            'producto' => $producto,
            'categorias' => $categorias,
            'proveedores' => $proveedores
        ];

        $this->view('productos/editar', $data);
    }

    public function deshabilitar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productoModel->disable($id)) {
                header('Location: ' . URLROOT . '/productos');
                exit;
            }
        }
    }

    public function inactivos() {
        $productos = $this->productoModel->getInactive();

        $data = [
            'title' => 'Productos Deshabilitados',
            'productos' => $productos
        ];

        $this->view('productos/inactivos', $data);
    }

    public function activar($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->productoModel->activate($id)) {
                header('Location: ' . URLROOT . '/productos/inactivos');
                exit;
            }
        }
    }
}
