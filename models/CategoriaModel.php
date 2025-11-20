<?php
// models/CategoriaModel.php

require_once 'Database.php';

class CategoriaModel {
    
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll() {
        // Agora pegamos também o status 'ativo'
        $sql = "SELECT id, nome, ativo FROM categorias";
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getById($id) {
        $sql = "SELECT id, nome, ativo FROM categorias WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function create($nome) {
        $sql = "INSERT INTO categorias (nome, ativo) VALUES (?, 1)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("s", $nome);
            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function update($id, $nome, $ativo) {
        $sql = "UPDATE categorias SET nome = ?, ativo = ? WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("sii", $nome, $ativo, $id);
            return $stmt->execute();
        }
        return false;
    }

    public function delete($id) {
        $sql = "DELETE FROM categorias WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
}
?>