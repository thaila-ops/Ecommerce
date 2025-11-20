<?php
// admin_dashboard/views/editar_categoria.php
require_once 'template_header.php';
?>

<h2>Editar Categoria</h2>

<form action="index.php?action=update_categoria" method="post" class="admin-form">
    <input type="hidden" name="id" value="<?php echo $categoria['id']; ?>">

    <div class="form-group">
        <label for="nome_categoria">Nome da Categoria:</label>
        <input type="text" name="nome_categoria" id="nome_categoria" 
               value="<?php echo htmlspecialchars($categoria['nome']); ?>" required>
    </div>

    <div class="form-group">
        <label>Status:</label>
        <br>
        <input type="checkbox" name="ativo" id="ativo" value="1" 
               <?php echo ($categoria['ativo'] == 1) ? 'checked' : ''; ?>>
        <label for="ativo">Categoria visível na loja</label>
    </div>

    <button type="submit" class="btn">Salvar Alterações</button>
    <a href="index.php?action=categorias" class="btn" style="background-color: #666;">Cancelar</a>
</form>

<?php require_once 'template_footer.php'; ?>