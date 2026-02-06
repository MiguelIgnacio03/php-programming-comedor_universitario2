<?php
/**
 * Producto Model
 */
class ProductoModel extends Model {
    protected function getTableName() {
        return 'productos';
    }

    /**
     * Get all products with details
     */
    /**
     * Get all products with details (Active only)
     * For disabling management, we might want a separate admin view for all products, 
     * but strictly complying with user request to disable:
     */
    public function getAllWithDetails($includeDisabled = false) {
        $whereClause = $includeDisabled ? "" : "WHERE p.estado = TRUE";
        
        $sql = "SELECT p.*, 
                       c.nombre as categoria, 
                       pr.nombre as proveedor,
                       COALESCE(SUM(CASE WHEN l.estado = 'disponible' THEN l.cantidad ELSE 0 END), 0) as stock_actual
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
                LEFT JOIN lotes l ON p.id = l.producto_id
                $whereClause
                GROUP BY p.id
                ORDER BY p.nombre ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Get product by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Check critical stock
     */
    public function checkStockCritico() {
        $sql = "SELECT p.*, 
                       c.nombre as categoria,
                       COALESCE(SUM(CASE WHEN l.estado = 'disponible' THEN l.cantidad ELSE 0 END), 0) as stock_actual
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN lotes l ON p.id = l.producto_id
                GROUP BY p.id
                HAVING stock_actual < p.stock_minimo
                ORDER BY stock_actual ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Create new product
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO productos (nombre, categoria_id, unidad_medida, stock_minimo, stock_maximo, precio_unitario, proveedor_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['categoria_id'],
            $data['unidad_medida'],
            $data['stock_minimo'],
            $data['stock_maximo'],
            $data['precio_unitario'],
            $data['proveedor_id']
        ]);
    }

    /**
     * Update product
     */
    /**
     * Update product
     */
    public function update($data) {
        $stmt = $this->db->prepare("UPDATE productos SET nombre = ?, categoria_id = ?, unidad_medida = ?, stock_minimo = ?, stock_maximo = ?, precio_unitario = ?, proveedor_id = ? WHERE id = ?");
        return $stmt->execute([
            $data['nombre'],
            $data['categoria_id'],
            $data['unidad_medida'],
            $data['stock_minimo'],
            $data['stock_maximo'],
            $data['precio_unitario'],
            $data['proveedor_id'],
            $data['id']
        ]);
    }

    /**
     * Disable product (Soft delete)
     */
    public function disable($id) {
        $stmt = $this->db->prepare("UPDATE productos SET estado = FALSE WHERE id = ?");
        return $stmt->execute([$id]);
    }


    /**
     * Get inactive products
     */
    public function getInactive() {
        $sql = "SELECT p.*, 
                       c.nombre as categoria, 
                       pr.nombre as proveedor
                FROM productos p
                LEFT JOIN categorias c ON p.categoria_id = c.id
                LEFT JOIN proveedores pr ON p.proveedor_id = pr.id
                WHERE p.estado = FALSE
                ORDER BY p.nombre ASC";
        return $this->db->query($sql)->fetchAll();
    }

    /**
     * Reactivate product
     */
    public function activate($id) {
        $stmt = $this->db->prepare("UPDATE productos SET estado = TRUE WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Delete product (Hard delete)
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM productos WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
