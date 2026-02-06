<?php
/**
 * Movimiento Model - Historial de transacciones
 */
class MovimientoModel extends Model {
    protected function getTableName() {
        return 'movimientos';
    }

    /**
     * Get all movements with details
     */
    public function getAllWithDetails($limit = 100) {
        $sql = "SELECT m.*, p.nombre as producto, u.nombre as usuario
                FROM movimientos m
                JOIN productos p ON m.producto_id = p.id
                JOIN usuarios u ON m.usuario_id = u.id
                ORDER BY m.fecha_movimiento DESC
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    /**
     * Get movements by date range for reports
     */
    public function getByDateRange($fechaInicio, $fechaFin) {
        // Add one day to end date to include the full day
        $fechaFin = date('Y-m-d', strtotime($fechaFin . ' +1 day'));
        
        $sql = "SELECT m.fecha_movimiento as fecha, 
                       m.tipo, 
                       m.cantidad, 
                       m.motivo as observaciones,
                       p.nombre as producto_nombre, 
                       u.nombre as usuario_nombre
                FROM movimientos m
                JOIN productos p ON m.producto_id = p.id
                JOIN usuarios u ON m.usuario_id = u.id
                WHERE m.fecha_movimiento >= ? AND m.fecha_movimiento < ?
                ORDER BY m.fecha_movimiento DESC";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fechaInicio, $fechaFin]);
        return $stmt->fetchAll();
    }

    /**
     * Register entrada (ingreso de stock)
     */
    public function registrarEntrada($productoId, $loteId, $cantidad, $usuarioId, $motivo = 'compra') {
        $stmt = $this->db->prepare("INSERT INTO movimientos (tipo, producto_id, lote_id, cantidad, usuario_id, motivo) VALUES ('entrada', ?, ?, ?, ?, ?)");
        return $stmt->execute([$productoId, $loteId, $cantidad, $usuarioId, $motivo]);
    }

    /**
     * Register salida (consumo de stock)
     */
    public function registrarSalida($productoId, $loteId, $cantidad, $usuarioId, $motivo = 'consumo') {
        $stmt = $this->db->prepare("INSERT INTO movimientos (tipo, producto_id, lote_id, cantidad, usuario_id, motivo) VALUES ('salida', ?, ?, ?, ?, ?)");
        return $stmt->execute([$productoId, $loteId, $cantidad, $usuarioId, $motivo]);
    }

    /**
     * Register ajuste (corrección de inventario)
     */
    public function registrarAjuste($productoId, $loteId, $cantidad, $usuarioId, $motivo) {
        $stmt = $this->db->prepare("INSERT INTO movimientos (tipo, producto_id, lote_id, cantidad, usuario_id, motivo) VALUES ('ajuste', ?, ?, ?, ?, ?)");
        return $stmt->execute([$productoId, $loteId, $cantidad, $usuarioId, $motivo]);
    }
}
