<?php 
// Inicia a sessão para poder usar $_SESSION mais tarde
session_start(); 

// Se o usuário já estiver logado, redireciona ele para o painel
if (isset($_SESSION['usuario_id'])) {
    header('Location: dashboard.php');
    exit;
}

// Inicializa a variável de erro
$erro_login = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']); // Limpa o erro após exibí-lo
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Painel Administrativo</title>
</head>
<body>

    <h2>Acesso ao Painel Administrativo</h2>

    <?php if ($erro_login): ?>
        <p style="color: red; border: 1px solid red; padding: 10px;">
            <?php echo htmlspecialchars($erro_login); ?>
        </p>
    <?php endif; ?>

    <form action="processa_login.php" method="POST">
        <div>
            <label for="username">Usuário (ou E-mail):</label>
            <input type="text" id="username" name="username" required>
        </div>
        <br>
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <br>
        <button type="submit">Entrar</button>
    </form>
    
</body>
</html>