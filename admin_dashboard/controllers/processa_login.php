<?php
// 1. INÍCIO E PREPARAÇÃO
session_start(); // Sempre inicie a sessão no topo!

// Inclui os arquivos necessários
require_once 'config.php';
require_once 'Database.php';

// Verifica se o formulário foi enviado usando o método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // Redireciona se o acesso não for via formulário (segurança básica)
    header('Location: login.php');
    exit;
}

// 2. COLETA E LIMPEZA DE DADOS
// Use htmlspecialchars para evitar ataques XSS
$username_input = htmlspecialchars(trim($_POST['username'] ?? ''));
$password_input = $_POST['password'] ?? '';

// Verifica se os campos estão preenchidos
if (empty($username_input) || empty($password_input)) {
    $_SESSION['login_error'] = "Por favor, preencha todos os campos.";
    header('Location: login.php');
    exit;
}

// 3. CONEXÃO E BUSCA NO BANCO DE DADOS
$db = new Database();
$conn = $db->conn;

// Prepara a consulta SQL para buscar o usuário. 
// O login pode ser feito pelo 'username' OU pelo 'email'.
$sql = "SELECT id, username, password, is_admin FROM usuarios WHERE username = ? OR email = ?";

// Usa Prepared Statements para EVITAR SQL Injection (segurança crítica!)
if ($stmt = $conn->prepare($sql)) {
    // Liga os parâmetros (os dois são strings 's')
    $stmt->bind_param("ss", $username_input, $username_input); 
    
    // Executa a consulta
    $stmt->execute();
    
    // Pega o resultado
    $result = $stmt->get_result();
    
    // Verifica se encontrou o usuário
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // 4. VERIFICAÇÃO DE SENHA (A CRÍTICA!)
        // Compara a senha digitada com o HASH armazenado no banco
        if (password_verify($password_input, $user['password'])) {
            
            // LOGIN BEM-SUCEDIDO!
            
            // 5. CRIAÇÃO DA SESSÃO
            // Armazena dados essenciais na sessão
            $_SESSION['usuario_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = $user['is_admin'];
            
            // 6. REDIRECIONAMENTO PARA O PAINEL
            header('Location: dashboard.php'); // Redireciona para o painel
            exit;
            
        } else {
            // Senha incorreta
            $error_message = "Credenciais inválidas. Tente novamente.";
        }
    } else {
        // Usuário não encontrado
        $error_message = "Credenciais inválidas. Tente novamente.";
    }
    
    // Fecha o statement
    $stmt->close();
} else {
    // Erro na preparação da query
    $error_message = "Erro interno. Tente novamente mais tarde.";
    // Em ambiente de desenvolvimento, você pode adicionar: 
    // echo "Erro: " . $conn->error;
}

// Fecha a conexão com o banco
$db->closeConnection();

// 7. TRATAMENTO DE ERRO (Se o código chegou até aqui, houve erro de login)
$_SESSION['login_error'] = $error_message ?? "Erro desconhecido.";

// Redireciona de volta para a página de login para mostrar a mensagem de erro
header('Location: login.php');
exit;
?>