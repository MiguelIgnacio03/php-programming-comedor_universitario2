<?php
/**
 * PDF Report Generator
 * Using basic HTML to PDF approach (FPDF alternative for simplicity)
 */
class ReportGenerator {
    
    /**
     * Generate Inventory Report
     */
    public static function generarReporteInventario() {
        require_once APPROOT . '/app/models/ProductoModel.php';
        require_once APPROOT . '/app/models/LoteModel.php';
        
        $productoModel = new ProductoModel();
        $loteModel = new LoteModel();
        
        $productos = $productoModel->getAllWithDetails();
        $stockCritico = $productoModel->checkStockCritico();
        $lotesVencen = $loteModel->getLotesProximosVencer();
        
        // Set headers for Browser Rendering
        header('Content-Type: text/html; charset=UTF-8');
        
        // For now, we'll use HTML to PDF conversion via browser print
        // In production, use libraries like TCPDF or FPDF
        self::renderInventarioHTML($productos, $stockCritico, $lotesVencen);
    }
    
    /**
     * Generate Consumption Report
     */
    public static function generarReporteConsumo($fechaInicio, $fechaFin) {
        require_once APPROOT . '/app/models/MovimientoModel.php';
        
        $movimientoModel = new MovimientoModel();
        $movimientos = $movimientoModel->getByDateRange($fechaInicio, $fechaFin);
        
        // Set headers for Browser Rendering
        header('Content-Type: text/html; charset=UTF-8');
        
        self::renderConsumoHTML($movimientos, $fechaInicio, $fechaFin);
    }
    
    /**
     * Render Inventory HTML (print-friendly)
     */
    private static function renderInventarioHTML($productos, $stockCritico, $lotesVencen) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Inventario</title>
            <style>
                @media print {
                    @page { margin: 1cm; }
                    body { margin: 0; }
                }
                body { font-family: Arial, sans-serif; font-size: 12px; }
                h1 { color: #2c3e50; border-bottom: 3px solid #3498db; padding-bottom: 10px; }
                h2 { color: #34495e; margin-top: 20px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th { background: #3498db; color: white; padding: 8px; text-align: left; }
                td { padding: 6px; border-bottom: 1px solid #ddd; }
                tr:nth-child(even) { background: #f9f9f9; }
                .critico { color: #e74c3c; font-weight: bold; }
                .header { text-align: center; margin-bottom: 20px; }
                .footer { margin-top: 30px; font-size: 10px; color: #7f8c8d; text-align: center; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>📊 REPORTE DE INVENTARIO</h1>
                <p><strong>Comedor Universitario</strong></p>
                <p>Fecha de generación: <?php echo date('d/m/Y H:i'); ?></p>
            </div>

            <h2>Resumen General</h2>
            <table>
                <tr>
                    <th>Métrica</th>
                    <th>Valor</th>
                </tr>
                <tr>
                    <td>Total de Productos</td>
                    <td><?php echo count($productos); ?></td>
                </tr>
                <tr>
                    <td>Productos con Stock Crítico</td>
                    <td class="critico"><?php echo count($stockCritico); ?></td>
                </tr>
                <tr>
                    <td>Lotes Próximos a Vencer (7 días)</td>
                    <td class="critico"><?php echo count($lotesVencen); ?></td>
                </tr>
            </table>

            <h2>Inventario Completo</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Proveedor</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($p['categoria']); ?></td>
                        <td class="<?php echo $p['stock_actual'] < $p['stock_minimo'] ? 'critico' : ''; ?>">
                            <?php echo $p['stock_actual']; ?> <?php echo $p['unidad_medida']; ?>
                        </td>
                        <td><?php echo $p['stock_minimo']; ?></td>
                        <td><?php echo htmlspecialchars($p['proveedor']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php if (!empty($stockCritico)): ?>
            <h2 style="color: #e74c3c;">⚠️ Alertas de Stock Crítico</h2>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Stock Actual</th>
                        <th>Stock Mínimo</th>
                        <th>Diferencia</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stockCritico as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['nombre']); ?></td>
                        <td class="critico"><?php echo $p['stock_actual']; ?></td>
                        <td><?php echo $p['stock_minimo']; ?></td>
                        <td class="critico"><?php echo $p['stock_minimo'] - $p['stock_actual']; ?> faltantes</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php endif; ?>

            <div class="footer">
                <p>Generado por Sistema de Control de Inventario - Comedor Universitario</p>
                <p>Este reporte es confidencial y de uso interno exclusivo</p>
            </div>

            <script>
                // Auto-print on load
                window.onload = function() { window.print(); }
            </script>
        </body>
        </html>
        <?php
        exit;
    }
    
    /**
     * Render Consumption HTML
     */
    private static function renderConsumoHTML($movimientos, $fechaInicio, $fechaFin) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>Reporte de Consumo</title>
            <style>
                @media print {
                    @page { margin: 1cm; }
                    body { margin: 0; }
                }
                body { font-family: Arial, sans-serif; font-size: 12px; }
                h1 { color: #2c3e50; border-bottom: 3px solid #e74c3c; padding-bottom: 10px; }
                table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
                th { background: #e74c3c; color: white; padding: 8px; text-align: left; }
                td { padding: 6px; border-bottom: 1px solid #ddd; }
                tr:nth-child(even) { background: #f9f9f9; }
                .header { text-align: center; margin-bottom: 20px; }
                .salida { color: #e74c3c; }
                .entrada { color: #27ae60; }
            </style>
        </head>
        <body>
            <div class="header">
                <h1>📉 REPORTE DE CONSUMO</h1>
                <p><strong>Comedor Universitario</strong></p>
                <p>Período: <?php echo date('d/m/Y', strtotime($fechaInicio)); ?> - <?php echo date('d/m/Y', strtotime($fechaFin)); ?></p>
                <p>Generado: <?php echo date('d/m/Y H:i'); ?></p>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Producto</th>
                        <th>Tipo</th>
                        <th>Cantidad</th>
                        <th>Usuario</th>
                        <th>Observaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($movimientos as $m): ?>
                    <tr>
                        <td><?php echo date('d/m/Y H:i', strtotime($m['fecha'])); ?></td>
                        <td><?php echo htmlspecialchars($m['producto_nombre']); ?></td>
                        <td class="<?php echo $m['tipo']; ?>"><?php echo strtoupper($m['tipo']); ?></td>
                        <td><?php echo $m['cantidad']; ?></td>
                        <td><?php echo htmlspecialchars($m['usuario_nombre']); ?></td>
                        <td><?php echo htmlspecialchars($m['observaciones']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <script>
                window.onload = function() { window.print(); }
            </script>
        </body>
        </html>
        <?php
        exit;
    }
}
