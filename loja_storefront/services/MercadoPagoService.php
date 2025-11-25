<?php

class MercadoPagoService
{
    private string $accessToken;
    private string $appUrl;

    public function __construct(string $accessToken, string $appUrl)
    {
        $this->accessToken = trim($accessToken);
        $this->appUrl = rtrim($appUrl, '/');
    }

    /**
     * Cria uma preferência no Mercado Pago usando a API HTTP pura.
     *
     * @param array $itens Estrutura do carrinho armazenada na sessão.
     * @return array Resposta da API (JSON decodificado).
     *
     * @throws RuntimeException Quando não há itens ou as credenciais não foram configuradas.
     */
    public function criarPreferencia(array $itens): array
    {
        if (empty($this->accessToken) || stripos($this->accessToken, 'SEU_') === 0) {
            throw new RuntimeException('Configure as credenciais do Mercado Pago em config.php antes de finalizar a compra.');
        }

        if (empty($itens)) {
            throw new RuntimeException('Nenhum item encontrado no carrinho.');
        }

        $payload = [
            'items' => array_map(function ($item) {
                return [
                    'title' => $item['nome'],
                    'quantity' => (int) $item['quantidade'],
                    'unit_price' => (float) $item['preco'],
                    'currency_id' => 'BRL',
                ];
            }, $itens),
            'back_urls' => [
                'success' => $this->appUrl . '?action=checkout_status&status=success',
                'failure' => $this->appUrl . '?action=checkout_status&status=failure',
                'pending' => $this->appUrl . '?action=checkout_status&status=pending',
            ],
            'auto_return' => 'approved',
            'payment_methods' => [
                'excluded_payment_types' => [],
                'installments' => 12,
            ],
            'statement_descriptor' => 'Doceria Alquimia III',
        ];

        return $this->executarRequisicao('https://api.mercadopago.com/checkout/preferences', $payload);
    }

    private function executarRequisicao(string $endpoint, array $payload): array
    {
        $ch = curl_init($endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->accessToken,
            ],
            CURLOPT_POSTFIELDS => json_encode($payload, JSON_UNESCAPED_UNICODE),
            CURLOPT_TIMEOUT => 20,
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($response === false) {
            throw new RuntimeException('Erro ao contatar o Mercado Pago: ' . $error);
        }

        $decoded = json_decode($response, true);
        if ($httpCode >= 400 || $decoded === null) {
            throw new RuntimeException('Falha ao criar preferência: ' . ($decoded['message'] ?? $response));
        }

        return $decoded;
    }
}

