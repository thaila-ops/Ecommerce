<?php
require_once __DIR__ . '/../../models/UsuarioModel.php';

class ClienteController {

    // Tela de Login
    public function login() {
        require __DIR__ . '/../views/login_cliente.phtml';
    }

    // Processa o Login
    public function processa_login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $model = new UsuarioModel();
            $user = $model->getByEmail($email);

            // Verifica se achou o usuário e se a senha bate (Texto plano)
            if ($user && $user['password'] === $password) {
                // Salva na sessão
                $_SESSION['cliente_id'] = $user['id'];
                $_SESSION['cliente_nome'] = $user['username'];
                
                header("Location: index.php"); // Manda para a Home
                exit;
            } else {
                $erro = "E-mail ou senha incorretos.";
                require __DIR__ . '/../views/login_cliente.phtml';
            }
        }
    }

    // Tela de Cadastro
    public function cadastro() {
        require __DIR__ . '/../views/cadastro_cliente.phtml';
    }

    // Processa o Cadastro
    public function processa_cadastro() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nome = $_POST['username'];
            $email = $_POST['email'];
            $senha = $_POST['password'];

            $model = new UsuarioModel();
            // Cria usuário com is_admin = 0 (Cliente)
            if ($model->create($nome, $email, $senha, 0)) {
                // Já loga o usuário direto após cadastrar
                $user = $model->getByEmail($email);
                $_SESSION['cliente_id'] = $user['id'];
                $_SESSION['cliente_nome'] = $user['username'];
                
                header("Location: index.php");
                exit;
            } else {
                $erro = "Erro: E-mail ou usuário já existe.";
                require __DIR__ . '/../views/cadastro_cliente.phtml';
            }
        }
    }

    // Sair
    public function logout() {
        unset($_SESSION['cliente_id']);
        unset($_SESSION['cliente_nome']);
        header("Location: index.php");
        exit;
    }
}
?>