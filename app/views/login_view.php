<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/style.css">
    <style>
        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
        }
        .login-box {
            background: white;
            padding: 3rem;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-box h1 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }
        .login-box p {
            text-align: center;
            color: #666;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--secondary-color);
        }
        .btn-login {
            width: 100%;
            padding: 1rem;
            background: var(--secondary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        .btn-login:hover {
            background: var(--primary-color);
        }
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 1rem;
            border-radius: 6px;
            margin-bottom: 1rem;
            border-left: 4px solid #dc3545;
        }
        .credentials-info {
            margin-top: 2rem;
            padding: 1rem;
            background: #e3f2fd;
            border-radius: 6px;
            font-size: 0.9rem;
        }
        .credentials-info strong {
            color: var(--primary-color);
        }
    </style>
</head>
<body>
    <script>window.URLROOT = '<?php echo URLROOT; ?>';</script>
    <div class="login-container">
        <div class="login-box">
            <h1>🍽️ Comedor Universitario</h1>
            <p>Sistema de Control de Inventario</p>

            <?php if (!empty($data['error'])): ?>
                <div class="error-message">
                    <?php echo $data['error']; ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo URLROOT; ?>/login">
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" required placeholder="usuario@comedor.edu">
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" required placeholder="••••••••">
                </div>

                <button type="submit" class="btn-login">Iniciar Sesión</button>
            </form>

            <div class="credentials-info">
                <strong>Credenciales de prueba:</strong><br>
                <small>
                    <strong>Admin:</strong> admin@comedor.edu / admin123<br>
                    <strong>Chef:</strong> chef@comedor.edu / admin123<br>
                    <strong>Inventario:</strong> inventario@comedor.edu / admin123
                </small>
            </div>
        </div>
    </div>
</body>
</html>
