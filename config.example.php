<?php
/*
 * Arquivo de configuração COMPARTILHADO.
 * 
 * INSTRUÇÕES:
 * 1. Copie este arquivo para config.php
 * 2. Preencha com suas credenciais reais
 * 3. NUNCA faça commit do config.php no Git!
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

// URL base usada nos retornos do Mercado Pago (ajuste para o domínio real em produção)
define('APP_URL', 'http://localhost/ecommerce-main/loja_storefront/index.php');

// Credenciais do Mercado Pago (obtenha em: https://www.mercadopago.com.br/developers/panel/credentials)
// Para pré-preencher valores dinamicamente, é necessário usar a API com Access Token
define('MP_ACCESS_TOKEN', 'SEU_ACCESS_TOKEN_AQUI'); // Substitua pelo seu Access Token do Mercado Pago

// Link de Pagamento do Mercado Pago (usado como fallback se não houver Access Token)
define('MP_LINK_PAGAMENTO', 'https://link.mercadopago.com.br/doceriaalquimia');

?>

