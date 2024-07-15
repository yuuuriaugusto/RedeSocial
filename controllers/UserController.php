<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Post.php'; // Importe o Model Post para buscar os posts do usuário

class UserController {
    private $pdo;
    private $user;
    private $post; 

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->user = new User($pdo);
        $this->post = new Post($pdo);
    }

    // Exibe o perfil do usuário logado
    public function profile() {
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /login');
            exit();
        }

        $usuario_id = $_SESSION['usuario_id'];
        $usuario = $this->user->findById($usuario_id);
        $posts = $this->post->getPostsByUserId($usuario_id); // Função para buscar posts do usuário (criaremos no Model Post)

        require __DIR__ . '/../views/profile.php'; 
    }

    // Exibe o perfil de um usuário específico (por ID)
    public function viewProfile() {
        $id = $_GET['id']; // Obtem o ID do usuário da URL

        $usuario = $this->user->findById($id);
        $posts = $this->post->getPostsByUserId($id);

        // Verificar se o usuário existe
        if (!$usuario) {
            http_response_code(404);
            echo "Usuário não encontrado!";
            exit();
        }

        // Incrementar a contagem de visitas (opcional)
        // ...

        require __DIR__ . '/../views/profile.php'; 
    }
}