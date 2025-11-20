<?php
session_start();

// Apaga a sessão
session_unset();
session_destroy();

// Manda de volta para a tela de login
header('Location: views/login.php');
exit;
?>