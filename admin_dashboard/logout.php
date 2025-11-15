<?php
session_start();

// 1. Limpa todas as variáveis de sessão
$_SESSION = array();

// 2. Destrói o cookie de sessão (opcional, mas recomendado)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 3. Destrói a sessão
session_destroy();

// 4. Redireciona o usuário para a página de login
header("Location: login.php");
exit;
?>