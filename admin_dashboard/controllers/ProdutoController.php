<?php
// CONTROLADOR (Controller)
// Responsável pela lógica de "Gerenciar Produtos"

require_once __DIR__ . '/../../models/ProdutoModel.php';
require_once __DIR__ . '/../../models/CategoriaModel.php'; // Precisa para o <select>

class ProdutoController {

    /**
     * Ação: index (ou listar)
     * Exibe a página de gerenciamento de produtos.
     */
    public function index() {
        // 1. Pede os dados aos Models
        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->getAllWithCategoria();
        
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->getAll(); // Para o dropdown do formulário

        // 2. Pega a mensagem de feedback da sessão
        $mensagem = $_SESSION['mensagem'] ?? null;
        unset($_SESSION['mensagem']);

        // 3. Chama a View e passa os dados
        require __DIR__ . '/../views/gerenciar_produtos.php';
    }

    /**
     * Ação: adicionar
     * Processa o formulário de adição de produto.
     */
    public function adicionar() {
        $mensagem_feedback = ""; // Mensagem de erro para o usuário
        $uploadOk = 0;

        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["nome_produto"])) {
            
            // --- Validação dos Campos ---
            $nome_produto = trim($_POST["nome_produto"]);
            $descricao = trim($_POST["descricao"]);
            $preco = floatval($_POST["preco"]);
            $categoria_id = intval($_POST["categoria_id"]);
            $imagem_nome = ""; // O nome do arquivo salvo

            // --- Processamento da Imagem (Lógica do Controller) ---
            if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
                
                // Usamos a constante do config.php
                $target_dir = UPLOAD_DIR; 
                $imagem_nome_original = basename($_FILES["imagem"]["name"]);
                $target_file = $target_dir . $imagem_nome_original;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["imagem"]["tmp_name"]);
                if($check !== false) {
                    if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg" || $imageFileType == "gif" ) {
                        // Tenta mover o arquivo
                        if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $target_file)) {
                            $imagem_nome = $imagem_nome_original; // Sucesso!
                            $uploadOk = 1;
                        } else {
                            $mensagem_feedback .= "<p class='erro'>Erro ao mover o arquivo de imagem.</p>";
                        }
                    } else {
                        $mensagem_feedback .= "<p class='erro'>Apenas arquivos JPG, JPEG, PNG e GIF são permitidos.</p>";
                    }
                } else {
                    $mensagem_feedback .= "<p class='erro'>O arquivo não é uma imagem.</p>";
                }
            } else {
                $mensagem_feedback .= "<p class='erro'>É necessário enviar uma imagem.</p>";
            }

            // --- Insere no Banco de Dados (Pede ao Model) ---
            if ($uploadOk == 1 && !empty($nome_produto) && $preco > 0 && $categoria_id > 0) {
                
                $model = new ProdutoModel();
                $sucesso = $model->create($nome_produto, $descricao, $preco, $categoria_id, $imagem_nome);

                if ($sucesso) {
                    $_SESSION['mensagem'] = "<p class='sucesso'>Produto cadastrado com sucesso!</p>";
                } else {
                    $_SESSION['mensagem'] = "<p class='erro'>Erro ao salvar no banco de dados.</p>";
                }

            } else {
                if(empty($mensagem_feedback)) {
                     $mensagem_feedback = "<p class='erro'>Por favor, preencha todos os campos corretamente.</p>";
                }
                $_SESSION['mensagem'] = $mensagem_feedback;
            }
        }
        
        // 3. Redireciona de volta para a página principal de produtos
        header("Location: index.php?action=produtos");
        exit;
    }
}
?>

