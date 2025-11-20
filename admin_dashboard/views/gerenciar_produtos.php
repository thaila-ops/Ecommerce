<?php
// admin_dashboard/views/gerenciar_produtos.php
require_once 'template_header.php';
?>

<script>document.title = 'Gerenciar Produtos';</script>
<style>
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; vertical-align: middle;}
    th { background-color: #f2f2f2; }
    .thumb-img { width: 50px; height: 50px; object-fit: cover; border-radius: 4px; }
    .btn-sm { padding: 5px 10px; font-size: 12px; text-decoration: none; color: white; border-radius: 3px; margin-right: 5px;}
    .btn-edit { background-color: #007bff; }
    .btn-delete { background-color: #dc3545; }
    .status-ativo { color: green; font-weight: bold; }
    .status-inativo { color: red; font-weight: bold; }
</style>

<h2>Gerenciar Produtos</h2>

<?php if (isset($mensagem)) echo $mensagem; ?>

<details>
    <summary style="cursor:pointer; padding:10px; background:#eee;">Clique para Adicionar Novo Produto</summary>
    <form action="index.php?action=add_produto" method="post" enctype="multipart/form-data" class="admin-form" style="margin-top:10px;">
        <div class="form-group"><label>Nome:</label><input type="text" name="nome_produto" required></div>
        <div class="form-group"><label>Preço:</label><input type="number" step="0.01" name="preco" required></div>
        <div class="form-group"><label>Categoria:</label>
            <select name="categoria_id" required>
                <?php foreach ($categorias as $cat) echo "<option value='{$cat['id']}'>{$cat['nome']}</option>"; ?>
            </select>
        </div>
        <div class="form-group"><label>Imagem:</label><input type="file" name="imagem" required></div>
        <div class="form-group"><label>Descrição:</label><textarea name="descricao"></textarea></div>
        <button type="submit" class="btn">Salvar Produto</button>
    </form>
</details>

<hr>

<h3>Lista de Produtos</h3>
<div class="lista-itens">
    <?php if (!empty($produtos)): ?>
        <table>
            <thead>
                <tr>
                    <th>Img</th>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $row): ?>
                <tr>
                    <td>
                        <?php 
                        // Caminho da imagem (ajuste o caminho relativo conforme onde esta pasta está)
                        $img_path = "../uploads/" . $row['imagem_nome']; 
                        ?>
                        <img src="<?php echo $img_path; ?>" class="thumb-img" alt="Foto">
                    </td>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td><?php echo htmlspecialchars($row['categoria_nome']); ?></td>
                    <td>R$ <?php echo number_format($row['preco'], 2, ',', '.'); ?></td>
                    <td>
                        <?php echo ($row['ativo'] == 1) 
                            ? "<span class='status-ativo'>Ativo</span>" 
                            : "<span class='status-inativo'>Inativo</span>"; ?>
                    </td>
                    <td>
                        <a href="index.php?action=edit_produto&id=<?php echo $row['id']; ?>" class="btn-sm btn-edit">Editar</a>
                        <a href="index.php?action=delete_produto&id=<?php echo $row['id']; ?>" 
                           class="btn-sm btn-delete" 
                           onclick="return confirm('Excluir este produto apaga a imagem também. Continuar?');">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhum produto encontrado.</p>
    <?php endif; ?>
</div>

<?php require_once 'template_footer.php'; ?>