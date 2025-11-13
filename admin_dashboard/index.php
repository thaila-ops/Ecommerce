<?php
// ROTEADOR DO ADMIN (Router)
// Este é o único arquivo que o navegador acessa no admin.
// Ele decide qual Controller chamar.

// Inicia a sessão para podermos usar $_SESSION para mensagens
session_start();

// Inclui a configuração e os controllers
require_once '../config.php';
require_once 'controllers/CategoriaController.php';
require_once 'controllers/ProdutoController.php';

// Pega a 'action' da URL. Ex: index.php?action=categorias
// Se nada for passado, o padrão é 'home'
$action = $_GET['action'] ?? 'home';

// Decide qual rota (qual função do controller) executar
switch ($action) {
    // ---- ROTAS DE CATEGORIA ----
    case 'categorias':
        $controller = new CategoriaController();
        $controller->index();
        break;
    
    case 'add_categoria':
        $controller = new CategoriaController();
        $controller->adicionar();
        break;
    
    // ---- ROTAS DE PRODUTO ----
    case 'produtos':
        $controller = new ProdutoController();
        $controller->index();
        break;

    case 'add_produto':
        $controller = new ProdutoController();
        $controller->adicionar();
        break;

    // ---- ROTA PADRÃO ----
    case 'home':
    default:
        // Se a ação não for reconhecida, mostra a home do admin
        require 'views/home.php';
        break;
}
?>