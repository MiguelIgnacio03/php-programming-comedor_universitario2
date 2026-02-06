<?php
/**
 * Usuario Model
 */
class UsuarioModel extends Model {
    protected function getTableName() {
        return 'usuarios';
    }

    /**
     * Find user by email
     * @param string $email
     * @return array|false
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    /**
     * Create a new user
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['nombre'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['rol'] ?? 'inventario'
        ]);
    }
}
