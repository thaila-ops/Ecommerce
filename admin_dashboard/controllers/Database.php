<?php
// Inclui o arquivo de configuração para acessar as constantes
require_once 'config.php'; 

class Database {
    private $host = DB_SERVER;
    private $user = DB_USERNAME;
    private $pass = DB_PASSWORD;
    private $dbname = DB_NAME;

    public $conn;

    /**
     * Construtor que estabelece a conexão
     */
    public function __construct() {
        $this->conn = null;

        try {
            // Cria uma nova instância de MySQLi
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

            // Define o charset para garantir o suporte a UTF-8 (acentos)
            $this->conn->set_charset("utf8mb4"); 
            
            // Verifica se houve erro na conexão
            if ($this->conn->connect_error) {
                // Em ambiente de produção, substitua por uma mensagem de erro genérica
                die("Erro de Conexão: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            // Em caso de exceção (erro de código), exibe o erro
            die("Erro: " . $e->getMessage());
        }
    }

    /**
     * Fecha a conexão com o banco de dados
     */
    public function closeConnection() {
        if ($this->conn) {
            $this->conn->close();
        }
    }
}
?>