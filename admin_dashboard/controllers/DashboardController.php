<?php

require_once '../models/Database.php';

class DashboardController {

    public function index() {
        $conn = Database::getConnection();

        // 1. Total de Produtos
        $queryProd = "SELECT COUNT(*) as total FROM produtos";
        $resultProd = $conn->query($queryProd);
        $totalProdutos = $resultProd->fetch_assoc()['total'];

        // 2. Total de Categorias
        $queryCat = "SELECT COUNT(*) as total FROM categorias";
        $resultCat = $conn->query($queryCat);
        $totalCategorias = $resultCat->fetch_assoc()['total'];

        // 3. Total de Vendas (Pedidos Pagos) e Faturamento
        $totalVendas = 0;
        $faturamento = 0.00;
        
        // Verificação de segurança caso a tabela ainda não exista
        $checkTable = $conn->query("SHOW TABLES LIKE 'pedidos'");
        
        if($checkTable->num_rows > 0) {
            $queryVendas = "SELECT COUNT(*) as total, SUM(total) as faturamento FROM pedidos WHERE status = 'pago'";
            $resultVendas = $conn->query($queryVendas);
            $dadosVendas = $resultVendas->fetch_assoc();
            $totalVendas = $dadosVendas['total'] ?? 0;
            $faturamento = $dadosVendas['faturamento'] ?? 0.00;
        }

        // 4. Produtos com Estoque Baixo (Menor que 5 unidades)
        $produtosBaixoEstoque = [];
        $checkCol = $conn->query("SHOW COLUMNS FROM produtos LIKE 'estoque'");
        
        if($checkCol->num_rows > 0) {
            $queryBaixo = "SELECT nome, estoque FROM produtos WHERE estoque < 5 ORDER BY estoque ASC LIMIT 5";
            $resultBaixo = $conn->query($queryBaixo);
            while($row = $resultBaixo->fetch_assoc()) {
                $produtosBaixoEstoque[] = $row;
            }
        }

        // Carrega a View passando as variáveis
        require 'views/home.php';
    }
}
?>