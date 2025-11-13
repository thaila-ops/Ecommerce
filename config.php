<?php
/*
 * Arquivo de configuração COMPARTILHADO.
*/

// --- CONFIGURE SEUS DADOS AQUI ---
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root'); // Seu usuário do MySQL
define('DB_PASSWORD', ''); // Sua senha do MySQL
define('DB_NAME', 'ecommerce_db'); // O nome do banco de dados
// ---------------------------------

// Define o caminho absoluto para a pasta de uploads
// __DIR__ é um atalho para a pasta ATUAL (meu_projeto_ecommerce_mvc)
define('UPLOAD_DIR', __DIR__ . '/uploads/');

// Define o charset para UTF-8
header('Content-Type: text/html; charset=utf-8');

?>