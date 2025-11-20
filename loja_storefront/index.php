<?php
// ROTEADOR DA LOJA
// Este arquivo controla qual página aparece (Home, Login, Cadastro...)

session_start(); 

// Configurações
require_once '../config.php';

// Controllers
require_once 'controllers/LojaController.php';
require_once 'controllers/ClienteController.php';

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

    // --- HOME PAGE (Padrão) ---
    case 'home':
    default:
        $controller = new LojaController();
        $controller->index();
        break;
}
?>