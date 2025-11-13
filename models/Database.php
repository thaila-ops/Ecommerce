<?php
// MODELO (Model)
// Responsável por criar e gerenciar a conexão com o banco de dados.
// Usamos um padrão "Singleton" para garantir que só exista UMA conexão.

class Database {

    // Guarda a única instância da conexão
    private static $link = null;

    // Construtor privado - impede que alguém crie um new Database()
    private function __construct() {}

    // Impede a clonagem
    private function __clone() {}

    // O método que todo mundo vai usar para pegar a conexão
    public static function getConnection() {
        
        // Se a conexão ainda não foi criada...
        if (self::$link === null) {
            // Inclui as constantes de configuração
            // __DIR__ é a pasta atual (models), então subimos um nível
            require_once __DIR__ . '/../config.php';
            
            // Tenta criar a conexão
            self::$link = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            // Verifica a conexão
            if(self::$link->connect_errno) {
                die("ERRO: Não foi possível conectar ao banco de dados. " . self::$link->connect_error);
            }

            // Define o charset
            self::$link->set_charset("utf8mb4");
        }
        
        // Retorna a conexão (nova ou a já existente)
        return self::$link;
    }
}
?>