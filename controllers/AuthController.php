<?php

require_once __DIR__ . '/../models/User.php'; // Inclui o Model User

class AuthController {
    private $pdo;
    private $user; // Propriedade para o Model User

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->user = new User($pdo); // Instancia o Model User
    }

    // Exibe o formulário de cadastro
    public function signup() {
        require __DIR__ . '/../views/signup.php';
    }

    // Processa o cadastro do usuário
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            // Validação básica (você pode adicionar mais validações)
            if (empty($nome) || empty($email) || empty($senha)) {
                $_SESSION['error'] = "Por favor, preencha todos os campos!";
                header('Location: /signup');
                exit();
            }

            // Verifica se já existe um usuário com o mesmo email
            if ($this->user->findByEmail($email)) {
                $_SESSION['error'] = "Já existe um usuário com este email!";
                header('Location: /signup');
                exit();
            }

            // Cria o usuário
            if ($this->user->create($nome, $email, $senha)) {
                $_SESSION['success'] = "Usuário cadastrado com sucesso!";
                header('Location: /login'); // Redireciona para o login
                exit();
            } else {
                $_SESSION['error'] = "Erro ao cadastrar usuário. Tente novamente.";
                header('Location: /signup');
                exit();
            }
        } else {
            header('Location: /signup'); // Redireciona se não for POST
            exit();
        }
    }

    // Exibe o formulário de login
    public function login() {
        require __DIR__ . '/../views/login.php';
    }

    // Processa o login do usuário
    public function authenticate() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $senha = $_POST['senha'];

            $usuario = $this->user->findByEmail($email);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Autenticação bem-sucedida!
                $_SESSION['usuario_id'] = $usuario['id'];
                header('Location: /'); // Redireciona para a página inicial
                exit();
            } else {
                $_SESSION['error'] = "Email ou senha inválidos!";
                header('Location: /login');
                exit();
            }
        } else {
            header('Location: /login'); 
            exit();
        }
    }

    // Faz o logout do usuário
    public function logout() {
        unset($_SESSION['usuario_id']);
        session_destroy();
        header('Location: /login');
        exit();
    }
}