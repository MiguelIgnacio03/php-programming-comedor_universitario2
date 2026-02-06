<?php
/**
 * Lote Model - Gestión de inventario por lotes
 */
class LoteModel extends Model {
    protected function getTableName() {
        return 'lotes';
    }

    /**
     * Get all lotes with product details
     */
    public function getAllWithDetails() {
        $sql = "SELECT l.*, p.nombre as producto, p.unidad_medida
                FROM lotes l
                JOIN productos p ON l.producto_id = p.id
                WHERE l.estado != 'deshabilitado'
                ORDER BY l.fecha_caducidad ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Get inactive (disabled) lotes
     */
    public function getInactive() {
        $sql = "SELECT l.*, p.nombre as producto, p.unidad_medida
                FROM lotes l
                JOIN productos p ON l.producto_id = p.id
                WHERE l.estado = 'deshabilitado'
                ORDER BY l.fecha_caducidad ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM lotes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function update($data) {
        $stmt = $this->db->prepare("UPDATE lotes SET producto_id = ?, numero_lote = ?, cantidad = ?, fecha_ingreso = ?, fecha_caducidad = ?, ubicacion = ? WHERE id = ?");
        return $stmt->execute([
            $data['producto_id'],
            $data['numero_lote'],
            $data['cantidad'],
            $data['fecha_ingreso'],
            $data['fecha_caducidad'],
            $data['ubicacion'],
            $data['id']
        ]);
    }

    public function disable($id) {
        return $this->updateEstado($id, 'deshabilitado');
    }

    public function activate($id) {
        // Default to 'disponible' when reactivating, assuming quantity > 0
        // Or check quantity? Let's assume disponible for now or use previous logic if complex.
        // Simple reactivation:
        return $this->updateEstado($id, 'disponible');
    }

    /**
     * Get lotes by product ID
     */
    public function getByProducto($productoId) {
        $stmt = $this->db->prepare("SELECT * FROM lotes WHERE producto_id = ? AND estado = 'disponible' ORDER BY fecha_caducidad ASC");
        $stmt->execute([$productoId]);
        return $stmt->fetchAll();
    }

    /**
     * Get lotes próximos a vencer (7 días)
     */
    public function getLotesProximosVencer() {
        $sql = "SELECT l.*, p.nombre as producto, p.unidad_medida,
                       DATEDIFF(l.fecha_caducidad, CURDATE()) as dias_restantes
                FROM lotes l
                JOIN productos p ON l.producto_id = p.id
                WHERE l.estado = 'disponible'
                AND l.fecha_caducidad BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)
                ORDER BY l.fecha_caducidad ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Create new lote
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO lotes (producto_id, numero_lote, cantidad, fecha_ingreso, fecha_caducidad, ubicacion) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([
            $data['producto_id'],
            $data['numero_lote'],
            $data['cantidad'],
            $data['fecha_ingreso'],
            $data['fecha_caducidad'],
            $data['ubicacion'] ?? 'Almacén General'
        ])) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    /**
     * Update lote quantity
     */
    public function updateCantidad($id, $cantidad) {
        $stmt = $this->db->prepare("UPDATE lotes SET cantidad = ? WHERE id = ?");
        return $stmt->execute([$cantidad, $id]);
    }

    /**
     * Update lote status
     */
    public function updateEstado($id, $estado) {
        $stmt = $this->db->prepare("UPDATE lotes SET estado = ? WHERE id = ?");
        return $stmt->execute([$estado, $id]);
    }
}
