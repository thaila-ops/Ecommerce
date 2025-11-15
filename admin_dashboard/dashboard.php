<?php
session_start();

// A VERIFICAÇÃO DE SEGURANÇA:
// Se a variável de sessão 'usuario_id' NÃO existir, 
// o usuário não está logado e será redirecionado para o login.
if (!isset($_SESSION['usuario_id'])) {
    // Você pode armazenar uma mensagem de "Acesso negado" na sessão, se quiser.
    header('Location: login.php');
    exit;
}

// Se o usuário está logado, a página continua a ser carregada
$nome_usuario = $_SESSION['username'];
$is_admin = $_SESSION['is_admin'] ? 'Sim' : 'Não';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Painel Administrativo</title>
</head>
<body>

    <h1>Bem-vindo ao Painel, <?php echo htmlspecialchars($nome_usuario); ?>!</h1>

    <p>Seu ID: <?php echo $_SESSION['usuario_id']; ?></p>
    <p>Você é administrador? <?php echo $is_admin; ?></p>
    
    <p><a href="logout.php">Sair (Logout)</a></p>

    </body>
</html>