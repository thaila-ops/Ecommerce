<?php
// admin_dashboard/views/editar_produto.php
require_once 'template_header.php';
?>

<h2>Editar Produto</h2>

<form action="index.php?action=update_produto" method="post" enctype="multipart/form-data" class="admin-form">
    
    <input type="hidden" name="id" value="<?php echo $produto['id']; ?>">
    <input type="hidden" name="imagem_atual" value="<?php echo $produto['imagem_nome']; ?>">

    <div class="form-group">
        <label>Nome:</label>
        <input type="text" name="nome_produto" value="<?php echo htmlspecialchars($produto['nome']); ?>" required>
    </div>

    <div class="form-group">
        <label>Preço:</label>
        <input type="number" step="0.01" name="preco" value="<?php echo $produto['preco']; ?>" required>
    </div>

    <div class="form-group">
        <label>Categoria:</label>
        <select name="categoria_id" required>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" 
                    <?php echo ($cat['id'] == $produto['categoria_id']) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($cat['nome']); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Imagem Atual:</label><br>
        <img src="../uploads/<?php echo $produto['imagem_nome']; ?>" style="max-width: 100px; border: 1px solid #ccc;">
        <br><br>
        <label>Trocar Imagem (Opcional):</label>
        <input type="file" name="imagem">
    </div>

    <div class="form-group">
        <label>Descrição:</label>
        <textarea name="descricao" rows="5"><?php echo htmlspecialchars($produto['descricao']); ?></textarea>
    </div>

    <div class="form-group">
        <label>Status:</label><br>
        <input type="checkbox" name="ativo" value="1" <?php echo ($produto['ativo'] == 1) ? 'checked' : ''; ?>>
        Disponível na loja
    </div>

    <button type="submit" class="btn">Salvar Alterações</button>
    <a href="index.php?action=produtos" class="btn" style="background:#666;">Cancelar</a>
</form>

<?php require_once 'template_footer.php'; ?>