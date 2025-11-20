<?php
// admin_dashboard/views/gerenciar_categorias.php
require_once 'template_header.php';
?>

<script>document.title = 'Gerenciar Categorias';</script>
<style>
    /* Pequeno CSS inline para organizar a tabela */
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
    th { background-color: #f2f2f2; }
    .btn-sm { padding: 5px 10px; font-size: 12px; text-decoration: none; color: white; border-radius: 3px; margin-right: 5px;}
    .btn-edit { background-color: #007bff; }
    .btn-delete { background-color: #dc3545; }
    .status-ativo { color: green; font-weight: bold; }
    .status-inativo { color: red; font-weight: bold; }
</style>

<h2>Gerenciar Categorias</h2>

<?php if (isset($mensagem)) echo $mensagem; ?>

<form action="index.php?action=add_categoria" method="post" class="admin-form" style="background:#f9f9f9; padding:15px; border:1px solid #eee;">
    <h3>Nova Categoria</h3>
    <div class="form-group">
        <input type="text" name="nome_categoria" placeholder="Nome da categoria..." required style="padding:8px; width:70%;">
        <button type="submit" class="btn">Adicionar</button>
    </div>
</form>

<hr>

<h3>Lista de Categorias</h3>
<div class="lista-itens">
    <?php if (!empty($categorias)): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $row): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td>
                        <?php echo ($row['ativo'] == 1) 
                            ? "<span class='status-ativo'>Ativo</span>" 
                            : "<span class='status-inativo'>Inativo</span>"; ?>
                    </td>
                    <td>
                        <a href="index.php?action=edit_categoria&id=<?php echo $row['id']; ?>" class="btn-sm btn-edit">Editar</a>
                        
                        <a href="index.php?action=delete_categoria&id=<?php echo $row['id']; ?>" 
                           class="btn-sm btn-delete" 
                           onclick="return confirm('Tem certeza que deseja excluir?');">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma categoria encontrada.</p>
    <?php endif; ?>
</div>

<?php require_once 'template_footer.php'; ?>