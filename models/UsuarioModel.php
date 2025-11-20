<?php
require_once 'Database.php';

class UsuarioModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    // Busca todos (usado no admin)
    public function getAll() {
        $sql = "SELECT id, username, email, is_admin FROM usuarios";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Agora aceita o parâmetro $is_admin (0 = cliente, 1 = admin)
    public function create($username, $email, $password, $is_admin = 0) {
        // Senha em texto plano conforme combinamos
        $sql = "INSERT INTO usuarios (username, email, password, is_admin) VALUES (?, ?, ?, ?)";
        
        if ($stmt = $this->db->prepare($sql)) {
            // sssi = string, string, string, int
            $stmt->bind_param("sssi", $username, $email, $password, $is_admin);
            return $stmt->execute();
        }
        return false;
    }

    // Busca usuário pelo email (Para o Login)
    public function getByEmail($email) {
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
        return null;
    }

    public function delete($id) {
        $sql = "DELETE FROM usuarios WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
}
?>