<?php
// admin_dashboard/controllers/CategoriaController.php

require_once __DIR__ . '/../../models/CategoriaModel.php';

class CategoriaController {

    public function index() {
        $model = new CategoriaModel();
        $categorias = $model->getAll();
        $mensagem = $_SESSION['mensagem'] ?? null;
        unset($_SESSION['mensagem']);
        require __DIR__ . '/../views/gerenciar_categorias.php';
    }

    public function adicionar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty(trim($_POST["nome_categoria"]))) {
                $nome = trim($_POST["nome_categoria"]);
                $model = new CategoriaModel();
                
                if ($model->create($nome)) {
                    $_SESSION['mensagem'] = "<p class='sucesso'>Categoria criada!</p>";
                } else {
                    $_SESSION['mensagem'] = "<p class='erro'>Erro ao criar.</p>";
                }
            }
        }
        header("Location: index.php?action=categorias");
        exit;
    }

    // --- NOVAS FUNÇÕES ---

    // Exibe o formulário de edição
    public function editar() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?action=categorias");
            exit;
        }

        $id = $_GET['id'];
        $model = new CategoriaModel();
        $categoria = $model->getById($id);

        if (!$categoria) {
            $_SESSION['mensagem'] = "<p class='erro'>Categoria não encontrada.</p>";
            header("Location: index.php?action=categorias");
            exit;
        }

        // Carrega uma view específica de edição (vamos criar abaixo)
        require __DIR__ . '/../views/editar_categoria.php';
    }

    // Processa a atualização
    public function atualizar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nome = trim($_POST['nome_categoria']);
            // Se o checkbox estiver marcado, envia 1, senão 0
            $ativo = isset($_POST['ativo']) ? 1 : 0;

            $model = new CategoriaModel();
            if ($model->update($id, $nome, $ativo)) {
                $_SESSION['mensagem'] = "<p class='sucesso'>Categoria atualizada!</p>";
            } else {
                $_SESSION['mensagem'] = "<p class='erro'>Erro ao atualizar.</p>";
            }
        }
        header("Location: index.php?action=categorias");
        exit;
    }

    // Exclui a categoria
    public function excluir() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = new CategoriaModel();
            
            if ($model->delete($id)) {
                $_SESSION['mensagem'] = "<p class='sucesso'>Categoria excluída!</p>";
            } else {
                $_SESSION['mensagem'] = "<p class='erro'>Erro ao excluir.</p>";
            }
        }
        header("Location: index.php?action=categorias");
        exit;
    }
}
?>