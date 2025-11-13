<?php
// VISÃO (View)
// As variáveis $mensagem, $categorias, e $produtos vêm do ProdutoController.

require_once 'template_header.php';
?>

<script>document.title = 'Gerenciar Produtos';</script>

<h2>Adicionar Novo Produto</h2>

<?php
// Exibe a mensagem de feedback (se houver)
if (isset($mensagem)) {
    echo $mensagem;
}
?>

<!-- Aponta para o roteador com a ação correta -->
<form action="index.php?action=add_produto" method="post" enctype="multipart/form-data" class="admin-form">
    
    <div class="form-group">
        <label for="nome_produto">Nome do Produto:</label>
        <input type="text" name="nome_produto" id="nome_produto" required>
    </div>

    <div class="form-group">
        <label for="descricao">Descrição:</label>
        <textarea name="descricao" id="descricao"></textarea>
    </div>

    <div class="form-group">
        <label for="preco">Preço (ex: 99.90):</label>
        <input type="number" name="preco" id="preco" step="0.01" required>
    </div>

    <div class="form-group">
        <label for="categoria_id">Categoria:</label>
        <select name="categoria_id" id="categoria_id" required>
            <option value="">Selecione...</option>
            <?php 
            // Loop nos dados das categorias para o dropdown
            foreach ($categorias as $cat) {
                echo "<option value='" . $cat['id'] . "'>" . htmlspecialchars($cat['nome']) . "</option>";
            }
            ?>
        </select>
    </div>

    <div class="form-group">
        <label for="imagem">Imagem do Produto:</label>
        <input type="file" name="imagem" id="imagem" required>
    </div>

    <button type="submit" class="btn">Salvar Produto</button>
</form>

<hr>

<h2>Produtos Cadastrados</h2>
<div class="lista-itens">
     <?php
    if (!empty($produtos)) {
        echo "<ul>";
        // Loop nos dados dos produtos
        foreach ($produtos as $row) {
            echo "<li>";
            echo "<strong>" . htmlspecialchars($row['nome']) . "</strong>";
            echo " (Cat: " . htmlspecialchars($row['categoria_nome']) . ")";
            echo " - R$ " . number_format($row['preco'], 2, ',', '.');
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhum produto encontrado.</p>";
    }
    ?>
</div>

<?php
require_once 'template_footer.php';
?>