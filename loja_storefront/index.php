<?php
// ROTEADOR DA LOJA (Router)
// Muito mais simples, pois só tem uma ação: mostrar a loja.

require_once '../config.php';
require_once 'controllers/LojaController.php';

// Pega a 'action' da URL.
$action = $_GET['action'] ?? 'index';

// A única ação é 'index'
$controller = new LojaController();
$controller->index();

?>