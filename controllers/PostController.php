<?php

require_once __DIR__ . '/../models/Post.php';

class PostController {
    private $pdo;
    private $post;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->post = new Post($pdo);
    }

    // Exibe a página inicial com o feed de posts
    public function index() {
        $posts = $this->post->getAllPosts();
        require __DIR__ . '/../views/home.php'; 
    }

    // Processa a criação de um novo post
    public function createPost() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario_id'])) {
            $usuario_id = $_SESSION['usuario_id'];
            $texto = $_POST['texto'];

            // Lógica para upload de imagem (se necessário)

            if ($this->post->create($usuario_id, $texto)) { 
                $_SESSION['success'] = "Post criado com sucesso!";
            } else {
                $_SESSION['error'] = "Erro ao criar post. Tente novamente.";
            }
        } 
        
        header('Location: /'); 
        exit();
    }
}