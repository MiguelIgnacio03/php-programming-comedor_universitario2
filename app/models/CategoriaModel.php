<?php
/**
 * Categoria Model
 */
class CategoriaModel extends Model {
    protected function getTableName() {
        return 'categorias';
    }

    /**
     * Get all categories
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM categorias WHERE estado = TRUE ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    public function getAllAdmin() {
        $stmt = $this->db->query("SELECT * FROM categorias ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    public function getInactive() {
        $stmt = $this->db->query("SELECT * FROM categorias WHERE estado = FALSE ORDER BY nombre ASC");
        return $stmt->fetchAll();
    }

    /**
     * Get category by ID
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM categorias WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO categorias (nombre, descripcion, perecedero, dias_caducidad, estado) VALUES (?, ?, ?, ?, TRUE)");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['perecedero'] ?? 1,
            $data['dias_caducidad'] ?? null
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE categorias SET nombre = ?, descripcion = ?, perecedero = ?, dias_caducidad = ? WHERE id = ?");
        return $stmt->execute([
            $data['nombre'],
            $data['descripcion'],
            $data['perecedero'],
            $data['dias_caducidad'],
            $id
        ]);
    }

    public function disable($id) {
        $stmt = $this->db->prepare("UPDATE categorias SET estado = FALSE WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function activate($id) {
        $stmt = $this->db->prepare("UPDATE categorias SET estado = TRUE WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
