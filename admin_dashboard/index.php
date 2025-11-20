<?php
// ROTEADOR DO ADMIN (Router)
session_start();

// --- BLOCO DE SEGURANÇA ---
// Se não tiver o ID do usuário na sessão, manda pro login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: views/login.php');
    exit; // Para tudo aqui
}
// --------------------------

require_once '../config.php';
require_once 'controllers/CategoriaController.php';
require_once 'controllers/ProdutoController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    // ---- CATEGORIAS ----
    case 'categorias':
        $controller = new CategoriaController();
        $controller->index();
        break;
    case 'add_categoria':
        $controller = new CategoriaController();
        $controller->adicionar();
        break;
    case 'edit_categoria':
        $controller = new CategoriaController();
        $controller->editar();
        break;
    case 'update_categoria':
        $controller = new CategoriaController();
        $controller->atualizar();
        break;
    case 'delete_categoria':
        $controller = new CategoriaController();
        $controller->excluir();
        break;
    
    // ---- PRODUTOS ----
    case 'produtos':
        $controller = new ProdutoController();
        $controller->index();
        break;
    case 'add_produto':
        $controller = new ProdutoController();
        $controller->adicionar();
        break;
    case 'edit_produto':
        $controller = new ProdutoController();
        $controller->editar();
        break;
    case 'update_produto':
        $controller = new ProdutoController();
        $controller->atualizar();
        break;
    case 'delete_produto':
        $controller = new ProdutoController();
        $controller->excluir();
        break;

    // ---- HOME ----
    case 'home':
    default:
        require 'views/home.php';
        break;
}
?>