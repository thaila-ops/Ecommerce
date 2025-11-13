-- Crie um banco de dados chamado `ecommerce_db` e execute este script.
-- Este arquivo é idêntico ao anterior.

-- Tabela de Categorias
CREATE TABLE `categorias` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Produtos
CREATE TABLE `produtos` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `descricao` TEXT NULL,
  `preco` DECIMAL(10, 2) NOT NULL,
  `categoria_id` INT NOT NULL,
  `imagem_nome` VARCHAR(255) NOT NULL, -- Apenas o nome do arquivo (ex: "produto.jpg")
  PRIMARY KEY (`id`),
  KEY `fk_produto_categoria` (`categoria_id`),
  CONSTRAINT `fk_produto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;