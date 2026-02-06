<?php
/**
 * Proveedor Model
 */
class ProveedorModel extends Model {
    protected function getTableName() {
        return 'proveedores';
    }

    /**
     * Get all suppliers
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM proveedores WHERE estado = TRUE ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    /**
     * Get supplier by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM proveedores WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Create new supplier
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO proveedores (nombre, contacto, telefono, email, direccion) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['contacto'] ?? null,
            $data['telefono'] ?? null,
            $data['email'] ?? null,
            $data['direccion'] ?? null
        ]);
    }

    /**
     * Update supplier
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE proveedores SET nombre = ?, contacto = ?, telefono = ?, email = ?, direccion = ? WHERE id = ?");
        return $stmt->execute([
            $data['nombre'],
            $data['contacto'],
            $data['telefono'],
            $data['email'],
            $data['direccion'],
            $id
        ]);
    }

    /**
     * Deactivate supplier
     */
    public function deactivate($id) {
        $stmt = $this->db->prepare("UPDATE proveedores SET estado = FALSE WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
