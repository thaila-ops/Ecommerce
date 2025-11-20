<?php
// models/ProdutoModel.php
require_once 'Database.php';

class ProdutoModel {
    
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllWithCategoria() {
        // Adicionado campo 'ativo'
        $sql = "SELECT p.*, c.nome AS categoria_nome 
                FROM produtos p
                JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.id DESC"; // Mais recentes primeiro
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // Busca dados de um produto específico para edição
    public function getById($id) {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_assoc();
        }
        return null;
    }

    public function create($nome, $descricao, $preco, $categoria_id, $imagem_nome) {
        $sql = "INSERT INTO produtos (nome, descricao, preco, categoria_id, imagem_nome, ativo) VALUES (?, ?, ?, ?, ?, 1)";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("ssdis", $nome, $descricao, $preco, $categoria_id, $imagem_nome);
            return $stmt->execute();
        }
        return false;
    }

    public function update($id, $nome, $descricao, $preco, $categoria_id, $imagem_nome, $ativo) {
        $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, categoria_id=?, imagem_nome=?, ativo=? WHERE id=?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("ssdisii", $nome, $descricao, $preco, $categoria_id, $imagem_nome, $ativo, $id);
            return $stmt->execute();
        }
        return false;
    }

    public function delete($id) {
        $sql = "DELETE FROM produtos WHERE id = ?";
        if ($stmt = $this->db->prepare($sql)) {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
}
?>