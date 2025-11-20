<?php
session_start();

// Pega erro se existir e limpa a sessão
$erro_login = $_SESSION['login_error'] ?? null;
unset($_SESSION['login_error']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Painel Administrativo</title>
    <!-- Caminho do CSS -->
    <link rel="stylesheet" href="../../style.css/style.css">
</head>

<body class="login-body">

    <div class="login-container">
        <h2 class="login-title">Acesso ao Painel</h2>

        <?php if (!empty($erro_login)): ?>
            <p class="login-error"><?= htmlspecialchars($erro_login) ?></p>
        <?php endif; ?>

        <!-- IMPORTANTE: Action aponta para o controller na pasta vizinha -->
        <form action="../controllers/processa_login.php" method="POST" class="login-form">

            <div class="input-group">
                <label for="username">Usuário</label>
                <input type="text" id="username" name="username" required>
            </div>

            <div class="input-group">
                <label for="password">Senha</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" class="login-btn">Entrar</button>
        </form>
    </div>

</body>
</html>