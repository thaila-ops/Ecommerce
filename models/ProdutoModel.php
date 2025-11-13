<?php
// MODELO (Model)
// Responsável por TODAS as interações com a tabela `produtos`

require_once 'Database.php';

class ProdutoModel {
    
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    /**
     * Busca todos os produtos, já com o nome da categoria (JOIN)
     * @return array - Lista de produtos
     */
    public function getAllWithCategoria() {
        $sql = "SELECT 
                    p.id, 
                    p.nome, 
                    p.descricao,
                    p.preco, 
                    p.imagem_nome,
                    c.nome AS categoria_nome 
                FROM produtos p
                JOIN categorias c ON p.categoria_id = c.id
                ORDER BY c.nome, p.nome";
        
        $result = $this->db->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Cria um novo produto
     * @param string $nome
     * @param string $descricao
     * @param float $preco
     * @param int $categoria_id
     * @param string $imagem_nome - Apenas o nome do arquivo
     * @return bool - true se sucesso, false se falha
     */
    public function create($nome, $descricao, $preco, $categoria_id, $imagem_nome) {
        
        $sql = "INSERT INTO produtos (nome, descricao, preco, categoria_id, imagem_nome) 
                VALUES (?, ?, ?, ?, ?)";
        
        if ($stmt = $this->db->prepare($sql)) {
            // s = string, d = double (decimal), i = integer
            $stmt->bind_param("ssdis", $nome, $descricao, $preco, $categoria_id, $imagem_nome);
            
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        $stmt->close();
        return false;
    }
}
?>