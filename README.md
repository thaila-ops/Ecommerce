# 🍰 Doceria Alquimia III - E-commerce

Sistema de e-commerce completo desenvolvido em PHP para a Doceria Alquimia III, com integração ao Mercado Pago.

## 📋 Características

- ✅ Sistema de carrinho de compras completo
- ✅ Integração com Mercado Pago (Checkout Pro)
- ✅ Painel administrativo para gestão de produtos e categorias
- ✅ Sistema de autenticação (clientes e administradores)
- ✅ Interface responsiva e moderna
- ✅ Upload de imagens de produtos

## 🛠️ Tecnologias Utilizadas

- **Backend:** PHP 7.4+
- **Banco de Dados:** MySQL
- **Frontend:** HTML5, CSS3, JavaScript
- **Pagamentos:** Mercado Pago API

## 📦 Instalação

1. Clone o repositório:
```bash
git clone https://github.com/SEU_USUARIO/Ecommerce-main.git
```

2. Configure o banco de dados:
   - Importe o arquivo `ecommerce_db.sql` no MySQL
   - Edite o arquivo `config.php` com suas credenciais do banco

3. Configure o Mercado Pago (opcional):
   - Obtenha seu Access Token em: https://www.mercadopago.com.br/developers/panel/credentials
   - Edite `config.php` e adicione seu `MP_ACCESS_TOKEN`

4. Configure o servidor:
   - Coloque os arquivos na pasta `htdocs` do XAMPP (ou servidor equivalente)
   - Acesse: `http://localhost/ecommerce-main/loja_storefront/index.php`

## 📁 Estrutura do Projeto

```
Ecommerce-main/
├── admin_dashboard/      # Painel administrativo
├── loja_storefront/      # Loja virtual (frontend)
├── models/              # Modelos de dados
├── uploads/             # Imagens dos produtos
├── style.css/           # Estilos CSS
└── config.php           # Configurações (não versionado)
```

## 🔐 Credenciais Padrão

**Admin:**
- Acesse: `http://localhost/ecommerce-main/admin_dashboard/`
- Configure as credenciais no banco de dados

## 📝 Configuração

Antes de usar, edite o arquivo `config.php`:

```php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'ecommerce_db');
define('MP_ACCESS_TOKEN', 'SEU_ACCESS_TOKEN_AQUI');
```

## 🚀 Funcionalidades

### Loja Virtual
- Visualização de produtos
- Carrinho de compras
- Checkout com Mercado Pago
- Sistema de login/cadastro de clientes

### Painel Administrativo
- Gerenciamento de produtos
- Gerenciamento de categorias
- Upload de imagens
- Controle de estoque

## 📄 Licença

Este projeto é de uso privado da Doceria Alquimia III.

## 👥 Desenvolvido por

Doceria Alquimia III - Transformando ingredientes em momentos doces ✨

