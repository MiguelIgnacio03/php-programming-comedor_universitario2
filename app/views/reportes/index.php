<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/style.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/public/assets/css/dashboard.css">
    <style>
        .report-card {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 2rem;
        }
        .report-card h2 {
            margin-top: 0;
            color: var(--primary-color);
        }
        .report-actions {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }
        .date-inputs {
            display: flex;
            gap: 1rem;
            margin: 1rem 0;
        }
        .date-inputs input {
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <?php include APPROOT . '/app/views/partials/navbar.php'; ?>
    
    <div class="dashboard">
        <?php include APPROOT . '/app/views/partials/sidebar.php'; ?>
        
        <main class="main-content">
            <h1>📄 Generador de Reportes PDF</h1>
            <p style="color: #666; margin-bottom: 2rem;">Genere reportes detallados del sistema de inventario</p>

            <div class="report-card">
                <h2>📊 Reporte de Inventario</h2>
                <p>Genera un reporte completo del estado actual del inventario, incluyendo:</p>
                <ul>
                    <li>Listado completo de productos con stock actual</li>
                    <li>Alertas de stock crítico</li>
                    <li>Lotes próximos a vencer</li>
                    <li>Resumen de métricas clave</li>
                </ul>
                <div class="report-actions">
                    <a href="<?php echo URLROOT; ?>/reportes/inventario" class="btn" target="_blank">
                        📥 Descargar Reporte de Inventario
                    </a>
                </div>
            </div>

            <div class="report-card">
                <h2>📉 Reporte de Consumo</h2>
                <p>Genera un reporte de movimientos de inventario (entradas y salidas) en un período específico:</p>
                
                <form method="GET" action="<?php echo URLROOT; ?>/reportes/consumo" target="_blank">
                    <div class="date-inputs">
                        <div>
                            <label for="fecha_inicio">Fecha Inicio:</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d', strtotime('-30 days')); ?>" required>
                        </div>
                        <div>
                            <label for="fecha_fin">Fecha Fin:</label>
                            <input type="date" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn">📥 Descargar Reporte de Consumo</button>
                </form>
            </div>

            <div style="background: #e3f2fd; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #2196f3;">
                <h3 style="margin-top: 0;">💡 Información</h3>
                <p>Los reportes se generan en formato HTML optimizado para impresión. Al hacer clic en "Descargar", se abrirá una nueva ventana con el reporte listo para imprimir o guardar como PDF usando la función de impresión de su navegador (Ctrl+P).</p>
                <p><strong>Recomendación:</strong> Use "Guardar como PDF" en el diálogo de impresión para conservar el formato.</p>
            </div>
        </main>
    </div>
</body>
</html>
