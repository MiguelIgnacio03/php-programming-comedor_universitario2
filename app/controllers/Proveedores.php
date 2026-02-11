<?php
/**
 * Proveedores Controller
 * CRUD for Suppliers - Admin Only
 */
class Proveedores extends Controller {
    private $proveedorModel;

    public function __construct() {
        // Security Check: Only Admins
        AuthMiddleware::handle('administrador');
        $this->proveedorModel = $this->model('ProveedorModel');
    }

    /**
     * List all active suppliers
     */
    public function index() {
        $proveedores = $this->proveedorModel->getAll();

        $data = [
            'title' => 'Gestión de Proveedores',
            'proveedores' => $proveedores
        ];

        $this->view('proveedores/index', $data);
    }

    /**
     * Create new supplier
     */
    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'nombre' => trim($_POST['nombre']),
                'contacto' => trim($_POST['contacto']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email']),
                'direccion' => trim($_POST['direccion']),
                'error' => ''
            ];

            if (empty($data['nombre'])) {
                $data['error'] = 'Por favor ingrese el nombre del proveedor';
            }

            // Validate contacto: only letters and spaces
            if (empty($data['error']) && !empty($data['contacto']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $data['contacto'])) {
                $data['error'] = 'El campo Contacto solo puede contener letras y espacios';
            }

            if (empty($data['error'])) {
                if ($this->proveedorModel->create($data)) {
                    header('Location: ' . URLROOT . '/proveedores');
                } else {
                    die('Algo salió mal');
                }
            } else {
                $this->view('proveedores/crear', $data);
            }
        } else {
            $data = [
                'nombre' => '',
                'contacto' => '',
                'telefono' => '',
                'email' => '',
                'direccion' => '',
                'error' => ''
            ];
            $this->view('proveedores/crear', $data);
        }
    }

    /**
     * Edit supplier
     */
    public function editar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

            $data = [
                'id' => $id,
                'nombre' => trim($_POST['nombre']),
                'contacto' => trim($_POST['contacto']),
                'telefono' => trim($_POST['telefono']),
                'email' => trim($_POST['email']),
                'direccion' => trim($_POST['direccion']),
                'error' => ''
            ];

            if (empty($data['nombre'])) {
                $data['error'] = 'Por favor ingrese el nombre del proveedor';
            }

            // Validate contacto: only letters and spaces
            if (empty($data['error']) && !empty($data['contacto']) && !preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/', $data['contacto'])) {
                $data['error'] = 'El campo Contacto solo puede contener letras y espacios';
            }

            if (empty($data['error'])) {
                if ($this->proveedorModel->update($id, $data)) {
                    header('Location: ' . URLROOT . '/proveedores');
                } else {
                    die('Algo salió mal');
                }
            } else {
                $this->view('proveedores/editar', $data);
            }
        } else {
            $proveedor = $this->proveedorModel->getById($id);

            // Check if exists
            if (!$proveedor) {
                header('Location: ' . URLROOT . '/proveedores');
            }

            $data = [
                'id' => $id,
                'nombre' => $proveedor['nombre'],
                'contacto' => $proveedor['contacto'],
                'telefono' => $proveedor['telefono'],
                'email' => $proveedor['email'],
                'direccion' => $proveedor['direccion'],
                'error' => ''
            ];

            $this->view('proveedores/editar', $data);
        }
    }

    /**
     * Soft delete supplier
     */
    public function eliminar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->proveedorModel->deactivate($id)) {
                header('Location: ' . URLROOT . '/proveedores');
            } else {
                die('Algo salió mal');
            }
        } else {
            header('Location: ' . URLROOT . '/proveedores');
        }
    }

    /**
     * List inactive suppliers
     */
    public function inactivos() {
        $proveedores = $this->proveedorModel->getInactive();

        $data = [
            'title' => 'Proveedores Deshabilitados',
            'proveedores' => $proveedores
        ];

        $this->view('proveedores/inactivos', $data);
    }

    /**
     * Reactivate supplier
     */
    public function activar($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($this->proveedorModel->activate($id)) {
                header('Location: ' . URLROOT . '/proveedores/inactivos');
            } else {
                die('Algo salió mal');
            }
        } else {
            header('Location: ' . URLROOT . '/proveedores/inactivos');
        }
    }
}
