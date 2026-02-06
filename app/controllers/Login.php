<?php
/**
 * Login Controller
 */
class Login extends Controller {
    public function index() {
        if (Auth::isLoggedIn()) {
            header('Location: ' . URLROOT . '/dashboard');
            exit;
        }

        $data = [
            'title' => 'Iniciar Sesión - Comedor Universitario',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (Auth::login($email, $password)) {
                header('Location: ' . URLROOT . '/dashboard');
                exit;
            } else {
                $data['error'] = 'Credenciales incorrectas o cuenta inactiva.';
            }
        }

        $this->view('login_view', $data);
    }

    public function logout() {
        Auth::logout();
        header('Location: ' . URLROOT . '/login');
        exit;
    }
}
