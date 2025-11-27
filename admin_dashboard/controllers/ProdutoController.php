<?php
require_once __DIR__ . '/../../models/ProdutoModel.php';
require_once __DIR__ . '/../../models/CategoriaModel.php';

// Define o diretório de uploads caso não esteja no config
if (!defined('UPLOAD_DIR')) {
    define('UPLOAD_DIR', __DIR__ . '/../../uploads/');
}

class ProdutoController {

    public function index() {
        $produtoModel = new ProdutoModel();
        $produtos = $produtoModel->getAllWithCategoria();
        
        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->getAll();

        $mensagem = $_SESSION['mensagem'] ?? null;
        unset($_SESSION['mensagem']);

        require __DIR__ . '/../views/gerenciar_produtos.php';
    }

    // --- ADICIONAR PRODUTO (Completo) ---
    public function adicionar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = trim($_POST["nome_produto"]);
            $descricao = trim($_POST["descricao"]);
            $preco = floatval($_POST["preco"]);
            // Adicionado campo Estoque (se não vier, assume 0)
            $estoque = isset($_POST["estoque"]) ? intval($_POST["estoque"]) : 0;
            $categoria_id = intval($_POST["categoria_id"]);
            
            // Lógica de Upload da Imagem
            $imagem_nome = "sem-imagem.jpg"; // Padrão caso falhe
            
            if (isset($_FILES["imagem"]) && $_FILES["imagem"]["error"] == 0) {
                $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
                // Gera nome único para não sobrescrever arquivos com mesmo nome
                $novo_nome = uniqid() . "." . $ext; 
                $destino = UPLOAD_DIR . $novo_nome;

                if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
                    $imagem_nome = $novo_nome;
                } else {
                    $_SESSION['mensagem'] = "<p class='erro'>Erro ao salvar a imagem na pasta uploads.</p>";
                    header("Location: index.php?action=produtos");
                    exit;
                }
            }

            $model = new ProdutoModel();
            // ATENÇÃO: O Model precisará ser atualizado para receber $estoque
            if ($model->create($nome, $descricao, $preco, $estoque, $categoria_id, $imagem_nome)) {
                $_SESSION['mensagem'] = "<p class='sucesso'>Produto cadastrado com sucesso!</p>";
            } else {
                $_SESSION['mensagem'] = "<p class='erro'>Erro ao salvar no banco de dados.</p>";
            }
        }
        header("Location: index.php?action=produtos");
        exit;
    }

    // --- EDITAR PRODUTO ---
    public function editar() {
        if (!isset($_GET['id'])) {
            header("Location: index.php?action=produtos");
            exit;
        }

        $id = $_GET['id'];
        $produtoModel = new ProdutoModel();
        $produto = $produtoModel->getById($id);

        if (!$produto) {
            $_SESSION['mensagem'] = "<p class='erro'>Produto não encontrado.</p>";
            header("Location: index.php?action=produtos");
            exit;
        }

        $categoriaModel = new CategoriaModel();
        $categorias = $categoriaModel->getAll();

        require __DIR__ . '/../views/editar_produto.php';
    }

    // --- ATUALIZAR PRODUTO ---
    public function atualizar() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $id = $_POST['id'];
            $nome = trim($_POST['nome_produto']);
            $descricao = trim($_POST['descricao']);
            $preco = floatval($_POST['preco']);
            // Adicionado campo Estoque
            $estoque = intval($_POST['estoque']);
            $categoria_id = intval($_POST['categoria_id']);
            $ativo = isset($_POST['ativo']) ? 1 : 0;
            
            $imagem_final = $_POST['imagem_atual']; 

            // Se enviou nova imagem, faz o upload
            if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
                $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
                $novo_nome = uniqid() . "." . $ext;
                $destino = UPLOAD_DIR . $novo_nome;
                
                if (move_uploaded_file($_FILES["imagem"]["tmp_name"], $destino)) {
                    $imagem_final = $novo_nome;
                    // Apaga a antiga se existir
                    if (!empty($_POST['imagem_atual']) && file_exists(UPLOAD_DIR . $_POST['imagem_atual'])) {
                        unlink(UPLOAD_DIR . $_POST['imagem_atual']);
                    }
                }
            }

            $model = new ProdutoModel();
            // ATENÇÃO: O Model precisará ser atualizado para receber $estoque
            if ($model->update($id, $nome, $descricao, $preco, $estoque, $categoria_id, $imagem_final, $ativo)) {
                $_SESSION['mensagem'] = "<p class='sucesso'>Produto atualizado!</p>";
            } else {
                $_SESSION['mensagem'] = "<p class='erro'>Erro ao atualizar.</p>";
            }
        }
        header("Location: index.php?action=produtos");
        exit;
    }

    // --- EXCLUIR PRODUTO ---
    public function excluir() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $model = new ProdutoModel();
            $produto = $model->getById($id);
            
            if ($produto) {
                // Apaga a imagem da pasta
                if (!empty($produto['imagem_nome']) && file_exists(UPLOAD_DIR . $produto['imagem_nome'])) {
                    unlink(UPLOAD_DIR . $produto['imagem_nome']);
                }
                // Apaga do banco
                if ($model->delete($id)) {
                    $_SESSION['mensagem'] = "<p class='sucesso'>Produto excluído!</p>";
                } else {
                    $_SESSION['mensagem'] = "<p class='erro'>Erro ao excluir do banco.</p>";
                }
            }
        }
        header("Location: index.php?action=produtos");
        exit;
    }
}
?>