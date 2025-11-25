<?php

require_once __DIR__ . '/../services/MercadoPagoService.php';

class PagamentoController
{
    public function checkout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirecionaCarrinho();
        }

        $itens = $_SESSION['carrinho'] ?? [];
        if (empty($itens)) {
            $this->definirMensagem('Adicione produtos antes de finalizar a compra.', 'erro');
            $this->redirecionaCarrinho();
        }

        // Tenta usar a API do Mercado Pago para criar preferência dinâmica (valor pré-preenchido)
        if (defined('MP_ACCESS_TOKEN') && !empty(MP_ACCESS_TOKEN) && stripos(MP_ACCESS_TOKEN, 'SEU_') !== 0) {
            try {
                $service = new MercadoPagoService(MP_ACCESS_TOKEN, APP_URL);
                $preferencia = $service->criarPreferencia(array_values($itens));

                if (isset($preferencia['init_point'])) {
                    // Redireciona para o checkout do Mercado Pago com valor pré-preenchido
                    header('Location: ' . $preferencia['init_point']);
                    exit;
                }

                throw new RuntimeException('Resposta inesperada ao criar a preferência de pagamento.');
            } catch (Throwable $e) {
                // Se falhar, usa o link direto como fallback
                $this->usarLinkDireto($itens);
            }
        } else {
            // Se não houver Access Token configurado, usa o link direto (sem valor pré-preenchido)
            $this->usarLinkDireto($itens);
        }
    }

    private function usarLinkDireto(array $itens): void
    {
        // Calcula o total para exibir mensagem
        $total = 0.0;
        foreach ($itens as $item) {
            $total += (float) $item['preco'] * (int) $item['quantidade'];
        }

        // Redireciona para o link de pagamento (sem valor pré-preenchido)
        // Nota: Links de pagamento do Mercado Pago não aceitam parâmetros na URL
        $this->definirMensagem(
            'Redirecionando para o pagamento. Por favor, insira o valor de R$ ' . number_format($total, 2, ',', '.') . ' manualmente.',
            'sucesso'
        );
        header('Location: ' . MP_LINK_PAGAMENTO);
        exit;
    }

    public function status(): void
    {
        $status = $_GET['status'] ?? 'pending';

        $mensagens = [
            'success' => ['texto' => 'Pagamento aprovado! Em breve entraremos em contato para confirmar sua entrega.', 'tipo' => 'sucesso'],
            'pending' => ['texto' => 'Seu pagamento está pendente. Assim que for aprovado avisaremos por aqui.', 'tipo' => 'sucesso'],
            'failure' => ['texto' => 'Pagamento não aprovado ou cancelado. Tente novamente.', 'tipo' => 'erro'],
        ];

        $this->definirMensagem($mensagens[$status]['texto'] ?? 'Status do pagamento atualizado.', $mensagens[$status]['tipo'] ?? 'sucesso');
        $this->redirecionaCarrinho();
    }

    private function definirMensagem(string $texto, string $tipo): void
    {
        $_SESSION['carrinho_mensagem'] = [
            'texto' => $texto,
            'tipo' => $tipo,
        ];
    }

    private function redirecionaCarrinho(): void
    {
        header('Location: /ecommerce-main/loja_storefront/index.php?action=carrinho');
        exit;
    }
}

