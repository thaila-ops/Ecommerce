<?php
// MODELO (Model)
// Responsável por TODAS as interações com a tabela `categorias`

require_once 'Database.php';

class CategoriaModel {
    
    private $db;

    public function __construct() {
        // Pega a conexão do banco de dados
        $this->db = Database::getConnection();
    }

    /**
     * Busca todas as categorias no banco
     * @return array - Lista de categorias
     */
    public function getAll() {
        $sql = "SELECT id, nome FROM categorias";
        $result = $this->db->query($sql);
        
        // Retorna todos os resultados como um array associativo
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    /**
     * Cria uma nova categoria
     * @param string $nome - O nome da nova categoria
     * @return bool - true se sucesso, false se falha
     */
    public function create($nome) {
        // Prepara um statement para evitar SQL Injection
        $sql = "INSERT INTO categorias (nome) VALUES (?)";
        
        if ($stmt = $this->db->prepare($sql)) {
            // "s" significa que o parâmetro é uma string
            $stmt->bind_param("s", $nome);
            
            if ($stmt->execute()) {
                $stmt->close();
                return true;
            }
        }
        // Se algo falhar
        $stmt->close();
        return false;
    }
}
?>