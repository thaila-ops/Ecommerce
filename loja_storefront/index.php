<?php
// ROTEADOR DA LOJA
// Este arquivo controla qual página aparece (Home, Login, Cadastro...)

session_start(); 

// Configurações
require_once '../config.php';

// Controllers
require_once 'controllers/LojaController.php';
require_once 'controllers/ClienteController.php';
require_once 'controllers/CarrinhoController.php';
require_once 'controllers/PagamentoController.php';

// Pega a ação da URL (se não tiver, assume 'home')
$action = $_GET['action'] ?? 'home';

// Decide o que carregar
switch ($action) {
    // --- ÁREA DO CLIENTE ---
    case 'login':
        (new ClienteController())->login();
        break;
        
    case 'processa_login':
        (new ClienteController())->processa_login();
        break;
        
    case 'cadastro':
        (new ClienteController())->cadastro();
        break;
        
    case 'processa_cadastro':
        (new ClienteController())->processa_cadastro();
        break;
        
    case 'logout':
        (new ClienteController())->logout();
        break;

    // --- CARRINHO ---
    case 'carrinho':
        (new CarrinhoController())->index();
        break;

    case 'add_carrinho':
        (new CarrinhoController())->adicionar();
        break;

    case 'atualiza_carrinho':
        (new CarrinhoController())->atualizar();
        break;

    case 'remove_item_carrinho':
        (new CarrinhoController())->remover();
        break;

    case 'limpa_carrinho':
        (new CarrinhoController())->limpar();
        break;

    // --- PAGAMENTO ---
    case 'checkout_pagamento':
        (new PagamentoController())->checkout();
        break;

    case 'checkout_status':
        (new PagamentoController())->status();
        break;

    // --- HOME PAGE (Padrão) ---
    case 'home':
    default:
        $controller = new LojaController();
        $controller->index();
        break;
}
?>