<?php
// VISÃO (View)
// Este arquivo é "burro". Ele só sabe exibir dados.
// As variáveis $mensagem e $categorias vêm do CategoriaController.

require_once 'template_header.php';
?>

<script>document.title = 'Gerenciar Categorias';</script>

<h2>Adicionar Nova Categoria</h2>

<?php 
// Exibe a mensagem de feedback (se houver)
if (isset($mensagem)) {
    echo $mensagem;
} 
?>

<!-- O formulário agora aponta para o ROTEADOR (index.php) -->
<form action="index.php?action=add_categoria" method="post" class="admin-form">
    <div class="form-group">
        <label for="nome_categoria">Nome da Categoria:</label>
        <input type="text" name="nome_categoria" id="nome_categoria" required>
    </div>
    <button type="submit" class="btn">Salvar Categoria</button>
</form>

<hr>

<h2>Categorias Existentes</h2>
<div class="lista-itens">
    <?php
    if (!empty($categorias)) {
        echo "<ul>";
        // Loop para exibir os dados recebidos do controller
        foreach ($categorias as $row) {
            echo "<li>" . htmlspecialchars($row['nome']) . " (ID: " . $row['id'] . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Nenhuma categoria encontrada.</p>";
    }
    ?>
</div>

<?php
// Inclui o rodapé
require_once 'template_footer.php';
?>