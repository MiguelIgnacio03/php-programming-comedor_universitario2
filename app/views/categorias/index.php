<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/dashboard.css">
</head>
<body>
    <?php include APPROOT . '/app/views/partials/navbar.php'; ?>
    
    <div class="dashboard">
        <?php include APPROOT . '/app/views/partials/sidebar.php'; ?>
        
        <main class="main-content">
            <div class="page-header">
                <div style="display:flex; align-items:center; gap: 1rem;">
                    <h1>🏷️ Gestión de Categorías</h1>
                </div>
                <div class="header-actions">
                    <a href="<?php echo URLROOT; ?>/categorias/inactivos" class="btn btn-secondary">🚫 Deshabilitados</a>
                    <a href="<?php echo URLROOT; ?>/categorias/crear" class="btn">+ Nueva Categoría</a>
                </div>
            </div>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['categorias'] as $cat): ?>
                        <tr style="<?php echo $cat['estado'] ? '' : 'opacity: 0.6; background: #f9f9f9;'; ?>">
                            <td>
                                <strong><?php echo htmlspecialchars($cat['nombre']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($cat['descripcion']); ?></td>
                            <td><?php echo $cat['perecedero'] ? 'Perecedero' : 'No Perecedero'; ?></td>
                            <td>
                                <?php if ($cat['estado']): ?>
                                    <span class="badge badge-success">Activo</span>
                                <?php else: ?>
                                    <span class="badge badge-danger">Inactivo</span>
                                <?php endif; ?>
                            </td>
                            <td class="actions-cell">
                                <a href="<?php echo URLROOT; ?>/categorias/editar/<?php echo $cat['id']; ?>" class="btn btn-sm btn-warning">✏️ Editar</a>
                                
                                <form action="<?php echo URLROOT; ?>/categorias/deshabilitar/<?php echo $cat['id']; ?>" method="POST" onsubmit="return confirm('¿Deshabilitar categoría? Esto podría ocultar productos asociados.');">
                                    <button type="submit" class="btn btn-sm btn-danger">🚫 Deshabilitar</button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
