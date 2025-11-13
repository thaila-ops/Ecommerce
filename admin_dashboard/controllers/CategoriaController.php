<?php
// CONTROLADOR (Controller)
// Responsável pela lógica de "Gerenciar Categorias"

// Inclui o Model, que busca os dados no BD
require_once __DIR__ . '/../../models/CategoriaModel.php';

class CategoriaController {

    /**
     * Ação: index (ou listar)
     * Exibe a página de gerenciamento de categorias.
     */
    public function index() {
        // 1. Pede os dados ao Model
        $model = new CategoriaModel();
        $categorias = $model->getAll(); // Pega todas as categorias

        // 2. Pega a mensagem (de sucesso ou erro) da sessão
        // Isso é usado para exibir feedback após um cadastro
        $mensagem = $_SESSION['mensagem'] ?? null;
        unset($_SESSION['mensagem']); // Limpa a mensagem da sessão

        // 3. Chama a View e passa os dados para ela
        // A View irá renderizar o HTML
        require __DIR__ . '/../views/gerenciar_categorias.php';
    }

    /**
     * Ação: adicionar
     * Processa o formulário de adição de categoria.
     */
    public function adicionar() {
        // Verifica se o formulário foi enviado (POST)
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (!empty(trim($_POST["nome_categoria"]))) {
                
                $nome_categoria = trim($_POST["nome_categoria"]);
                
                // 1. Pede ao Model para criar a categoria
                $model = new CategoriaModel();
                $sucesso = $model->create($nome_categoria);

                // 2. Define a mensagem de feedback
                if ($sucesso) {
                    $_SESSION['mensagem'] = "<p class='sucesso'>Categoria cadastrada com sucesso!</p>";
                } else {
                    $_SESSION['mensagem'] = "<p class='erro'>Ops! Algo deu errado. Tente novamente.</p>";
                }

            } else {
                $_SESSION['mensagem'] = "<p class='erro'>Por favor, insira um nome para a categoria.</p>";
            }
        }

        // 3. Redireciona de volta para a página principal de categorias
        // Isso evita o reenvio do formulário se o usuário atualizar a página (Padrão Post-Redirect-Get)
        header("Location: index.php?action=categorias");
        exit;
    }
}
?>