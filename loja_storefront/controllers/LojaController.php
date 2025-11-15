<?php
// CONTROLADOR (Controller)
// Responsável pela lógica da Loja

require_once __DIR__ . '/../../models/ProdutoModel.php';

class LojaController {

    /**
     * Ação: index (ou listar)
     * Exibe a página da loja com os produtos.
     */
    public function index() {
        // 1. Pede os dados ao Model
        $model = new ProdutoModel();
        $produtos = $model->getAllWithCategoria();

        // 2. Chama a View e passa os dados
        require __DIR__ . '/../views/index_loja.phtml';
    }
}
?>