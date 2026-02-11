<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/dashboard.css">
    <link rel="icon" href="<?php echo URLROOT; ?>/public/favicon.ico" type="image/x-icon">
</head>
<body>
    <?php include APPROOT . '/app/views/partials/navbar.php'; ?>
    
    <div class="dashboard">
        <?php include APPROOT . '/app/views/partials/sidebar.php'; ?>
        
        <main class="main-content">
            <div class="page-header">
                <h1>🏢 Gestión de Proveedores</h1>
                <div style="display:flex; gap: 1rem; align-items: center;">
                    <a href="<?php echo URLROOT; ?>/proveedores/inactivos" class="btn btn-sm btn-danger" style="display: flex; align-items: center; gap: 0.5rem;">👁️ Ver Deshabilitados</a>
                    <a href="<?php echo URLROOT; ?>/proveedores/crear" class="btn btn-primary">+ Nuevo Proveedor</a>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Contacto</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['proveedores'] as $proveedor): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($proveedor['nombre']); ?></strong></td>
                            <td><?php echo htmlspecialchars($proveedor['contacto']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['telefono']); ?></td>
                            <td><?php echo htmlspecialchars($proveedor['email']); ?></td>
                            <td style="font-size: 0.9em; max-width: 200px;"><?php echo htmlspecialchars($proveedor['direccion']); ?></td>
                            <td class="actions-cell">
                                <a href="<?php echo URLROOT; ?>/proveedores/editar/<?php echo $proveedor['id']; ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                                <form action="<?php echo URLROOT; ?>/proveedores/eliminar/<?php echo $proveedor['id']; ?>" method="POST" onsubmit="return confirm('¿Estás seguro de deshabilitar este proveedor?');">
                                    <button type="submit" class="btn btn-sm btn-danger">🚫 Deshabilitar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if (empty($data['proveedores'])): ?>
                    <p style="text-align:center; padding: 2rem;">No hay proveedores registrados.</p>
                <?php endif; ?>
            </div>
        </main>
    </div>
</body>
</html>
