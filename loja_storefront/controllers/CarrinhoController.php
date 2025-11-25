<?php
require_once __DIR__ . '/../../models/ProdutoModel.php';

class CarrinhoController
{
    private $produtoModel;

    public function __construct()
    {
        $this->produtoModel = new ProdutoModel();
        $this->garanteSessaoCarrinho();
    }

    public function index(): void
    {
        $itens = $_SESSION['carrinho'] ?? [];
        $total = $this->calculaTotal($itens);
        $mensagem = $_SESSION['carrinho_mensagem'] ?? null;
        unset($_SESSION['carrinho_mensagem']);

        require __DIR__ . '/../views/carrinho.phtml';
    }

    public function adicionar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireciona();
        }

        $produtoId = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

        if (!$produtoId || !$quantidade || $quantidade < 1) {
            $this->setMensagem('Quantidade ou produto inválido.', 'erro');
            $this->redireciona();
        }

        $produto = $this->produtoModel->getById($produtoId);

        if (!$produto) {
            $this->setMensagem('Produto não encontrado.', 'erro');
            $this->redireciona();
        }

        if (isset($_SESSION['carrinho'][$produtoId])) {
            $_SESSION['carrinho'][$produtoId]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$produtoId] = [
                'id' => $produto['id'],
                'nome' => $produto['nome'],
                'preco' => (float) $produto['preco'],
                'imagem_nome' => $produto['imagem_nome'] ?? null,
                'quantidade' => $quantidade,
            ];
        }

        $this->setMensagem('Produto adicionado ao carrinho!', 'sucesso');
        $this->redireciona();
    }

    public function atualizar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireciona();
        }

        $quantidades = $_POST['quantidades'] ?? [];

        foreach ($quantidades as $produtoId => $quantidade) {
            $produtoId = (int) $produtoId;
            $quantidade = (int) $quantidade;

            if (!isset($_SESSION['carrinho'][$produtoId])) {
                continue;
            }

            if ($quantidade <= 0) {
                unset($_SESSION['carrinho'][$produtoId]);
            } else {
                $_SESSION['carrinho'][$produtoId]['quantidade'] = $quantidade;
            }
        }

        $this->setMensagem('Carrinho atualizado com sucesso!', 'sucesso');
        $this->redireciona();
    }

    public function remover(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireciona();
        }

        $produtoId = filter_input(INPUT_POST, 'produto_id', FILTER_VALIDATE_INT);

        if ($produtoId && isset($_SESSION['carrinho'][$produtoId])) {
            unset($_SESSION['carrinho'][$produtoId]);
            $this->setMensagem('Item removido do carrinho.', 'sucesso');
        } else {
            $this->setMensagem('Item não encontrado no carrinho.', 'erro');
        }

        $this->redireciona();
    }

    public function limpar(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redireciona();
        }

        $_SESSION['carrinho'] = [];
        $this->setMensagem('Carrinho esvaziado.', 'sucesso');
        $this->redireciona();
    }

    private function garanteSessaoCarrinho(): void
    {
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    private function calculaTotal(array $itens): float
    {
        $total = 0.0;
        foreach ($itens as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
        return $total;
    }

    private function redireciona(string $action = 'carrinho'): void
    {
        header("Location: /ecommerce-main/loja_storefront/index.php?action={$action}");
        exit;
    }

    private function setMensagem(string $texto, string $tipo): void
    {
        $_SESSION['carrinho_mensagem'] = [
            'texto' => $texto,
            'tipo' => $tipo,
        ];
    }
}

