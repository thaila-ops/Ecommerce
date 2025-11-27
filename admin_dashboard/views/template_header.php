<?php
// VISÃO (View)
// Header e Navegação. Incluído em todas as outras views.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- O título será definido pela view específica -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><a href="index.php?action=home">Painel de Controle</a></h1>
        </header>
        <nav>
            <?php // Define a classe 'active' com base na ação atual
                $action_atual = $_GET['action'] ?? 'home';
            ?>
            <a href="index.php?action=home" 
               class="<?php echo ($action_atual == 'home') ? 'active' : ''; ?>">
               Home
            </a>
            <a href="index.php?action=categorias" 
               class="<?php echo ($action_atual == 'categorias') ? 'active' : ''; ?>">
               Gerenciar Categorias
            </a>
            <a href="index.php?action=produtos" 
               class="<?php echo ($action_atual == 'produtos') ? 'active' : ''; ?>">
               Gerenciar Produtos
            </a>
            
            <!-- Link de Sair adicionado aqui -->
            <a href="logout.php" style="float: right; color: red;">Sair</a>
        </nav>
        <main>