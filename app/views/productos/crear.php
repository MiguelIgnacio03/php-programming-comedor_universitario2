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
            <div class="header-flex">
                <h1>📦 Nuevo Producto</h1>
                <a href="<?php echo URLROOT; ?>/productos" class="btn btn-secondary">Cancelar</a>
            </div>

            <div class="card">
                <form action="<?php echo URLROOT; ?>/productos/crear" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="nombre">Nombre del Producto</label>
                            <input type="text" id="nombre" name="nombre" required placeholder="Ej: Arroz Grano Largo">
                        </div>

                        <div class="form-group">
                            <label for="categoria_id">Categoría</label>
                            <select id="categoria_id" name="categoria_id" required>
                                <option value="">Seleccione una categoría...</option>
                                <?php foreach ($data['categorias'] as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>">
                                        <?php echo htmlspecialchars($cat['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="unidad_medida">Unidad de Medida</label>
                            <select id="unidad_medida" name="unidad_medida" required>
                                <option value="kg">Kilogramos (kg)</option>
                                <option value="litros">Litros (L)</option>
                                <option value="unidades">Unidades (u)</option>
                                <option value="paquetes">Paquetes / Latas</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="precio_unitario">Precio Unitario (Bs)</label>
                            <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" required placeholder="0.00">
                        </div>

                        <div class="form-group">
                            <label for="stock_minimo">Stock Mínimo (Alerta)</label>
                            <input type="number" step="0.01" id="stock_minimo" name="stock_minimo" required placeholder="Ej: 10">
                        </div>

                        <div class="form-group">
                            <label for="stock_maximo">Stock Máximo</label>
                            <input type="number" step="0.01" id="stock_maximo" name="stock_maximo" required placeholder="Ej: 100">
                        </div>

                        <div class="form-group">
                            <label for="proveedor_id">Proveedor Principal</label>
                            <select id="proveedor_id" name="proveedor_id" required>
                                <option value="">Seleccione un proveedor...</option>
                                <?php foreach ($data['proveedores'] as $prov): ?>
                                    <option value="<?php echo $prov['id']; ?>">
                                        <?php echo htmlspecialchars($prov['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions" style="margin-top: 2rem;">
                        <button type="submit" class="btn">Guardar Producto</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
