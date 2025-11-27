<?php
// Inclui o cabeçalho
require_once 'template_header.php';
?>

<style>
    /* Estilos Específicos do Dashboard */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .card-dashboard {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        text-align: center;
        border-left: 5px solid #007bff;
    }

    .card-dashboard h3 {
        margin: 0;
        font-size: 16px;
        color: #666;
    }

    .card-dashboard .numero {
        font-size: 32px;
        font-weight: bold;
        color: #333;
        margin: 10px 0;
    }

    .card-dashboard.verde { border-left-color: #28a745; }
    .card-dashboard.laranja { border-left-color: #ffc107; }
    .card-dashboard.vermelho { border-left-color: #dc3545; }

    .alerta-estoque {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .alerta-estoque h2 { margin-top: 0; color: #dc3545; font-size: 20px; }
    .lista-estoque { list-style: none; padding: 0; }
    .lista-estoque li {
        padding: 10px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
    }
    .badge-estoque {
        background: #dc3545;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
    }
</style>

<div class="header-page">
    <h1>Dashboard Administrativo</h1>
    <p>Visão geral da sua loja</p>
</div>

<!-- Grid de Cards -->
<div class="dashboard-grid">
    
    <!-- Card Produtos -->
    <div class="card-dashboard">
        <h3>Produtos Cadastrados</h3>
        <div class="numero"><?php echo $totalProdutos; ?></div>
        <a href="index.php?action=produtos">Gerenciar</a>
    </div>

    <!-- Card Categorias -->
    <div class="card-dashboard laranja">
        <h3>Categorias</h3>
        <div class="numero"><?php echo $totalCategorias; ?></div>
        <a href="index.php?action=categorias">Gerenciar</a>
    </div>

    <!-- Card Vendas -->
    <div class="card-dashboard verde">
        <h3>Vendas Realizadas</h3>
        <div class="numero"><?php echo $totalVendas; ?></div>
        <small>Faturamento: R$ <?php echo number_format($faturamento, 2, ',', '.'); ?></small>
    </div>

</div>

<!-- Seção de Alertas -->
<?php if (!empty($produtosBaixoEstoque)): ?>
<div class="alerta-estoque">
    <h2>⚠️ Alerta de Estoque Baixo</h2>
    <p>Os seguintes produtos estão com menos de 5 unidades:</p>
    <ul class="lista-estoque">
        <?php foreach ($produtosBaixoEstoque as $prod): ?>
            <li>
                <span><?php echo htmlspecialchars($prod['nome']); ?></span>
                <span class="badge-estoque"><?php echo $prod['estoque']; ?> rest.</span>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
<?php else: ?>
    <div class="alerta-estoque" style="border-left: 5px solid #28a745;">
        <h2 style="color: #28a745;">✅ Estoque Saudável</h2>
        <p>Nenhum produto está com estoque crítico no momento.</p>
    </div>
<?php endif; ?>

<?php
// Inclui o rodapé
require_once 'template_footer.php';
?>