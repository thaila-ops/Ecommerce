<?php
// models/ProdutoModel.php
require_once 'Database.php';

class ProdutoModel {
    
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAllWithCategoria() {
        // Seleciona tudo (p.*), o que agora inclui a coluna 'estoque'
        $sql = "SELECT p.*, c.nome AS categoria_nome 
                FROM produtos p
                JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.id DESC"; 
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

    // --- ATUALIZADO: Recebe $estoque ---
    public function create($nome, $descricao, $preco, $estoque, $categoria_id, $imagem_nome) {
        // Adicionado campo estoque no INSERT
        $sql = "INSERT INTO produtos (nome, descricao, preco, estoque, categoria_id, imagem_nome, ativo) VALUES (?, ?, ?, ?, ?, ?, 1)";
        
        if ($stmt = $this->db->prepare($sql)) {
            // Tipos: s=string, s=string, d=double, i=integer (estoque), i=integer (cat), s=string
            $stmt->bind_param("ssdiis", $nome, $descricao, $preco, $estoque, $categoria_id, $imagem_nome);
            return $stmt->execute();
        }
        return false;
    }

    // --- ATUALIZADO: Recebe $estoque ---
    public function update($id, $nome, $descricao, $preco, $estoque, $categoria_id, $imagem_nome, $ativo) {
        // Adicionado campo estoque no UPDATE
        $sql = "UPDATE produtos SET nome=?, descricao=?, preco=?, estoque=?, categoria_id=?, imagem_nome=?, ativo=? WHERE id=?";
        
        if ($stmt = $this->db->prepare($sql)) {
            // Tipos: s, s, d, i (estoque), i, s, i, i (id no final)
            $stmt->bind_param("ssdiisii", $nome, $descricao, $preco, $estoque, $categoria_id, $imagem_nome, $ativo, $id);
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