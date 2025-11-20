<?php
session_start(); 

// Ajuste de caminhos
require_once '../../config.php'; 
require_once '../../models/Database.php'; 

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../views/login.php');
    exit;
}

$username_input = trim($_POST['username'] ?? '');
$password_input = $_POST['password'] ?? '';

if (empty($username_input) || empty($password_input)) {
    $_SESSION['login_error'] = "Preencha todos os campos.";
    header('Location: ../views/login.php');
    exit;
}

// --- CORREÇÃO AQUI ---
try {
    // NÃO use "new Database()". O construtor é privado.
    // Use o método estático diretamente para pegar a conexão.
    $conn = Database::getConnection(); 
    
} catch (Exception $e) {
    $_SESSION['login_error'] = "Erro de conexão.";
    header('Location: ../views/login.php');
    exit;
}
// ---------------------

$sql = "SELECT id, username, password, is_admin FROM usuarios WHERE username = ? OR email = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("ss", $username_input, $username_input); 
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Comparação de senha (Texto Plano)
        if ($password_input === $user['password']) {
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            header('Location: ../index.php'); 
            exit;
        } else {
            $error_message = "Senha incorreta.";
        }
    } else {
        $error_message = "Usuário não encontrado.";
    }
    $stmt->close();
} else {
    $error_message = "Erro no sistema.";
}

// Fecha conexão (se for mysqli direto)
// Nota: Se getConnection retorna a conexão MySQLi, usamos close()
// Se sua classe Database não fecha sozinha, podemos tentar fechar aqui, 
// mas num Singleton geralmente a conexão fica aberta para o resto do script.
// $conn->close(); 

$_SESSION['login_error'] = $error_message ?? "Erro desconhecido.";
header('Location: ../views/login.php');
exit;
?>