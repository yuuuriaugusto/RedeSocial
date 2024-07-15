<?php

require_once __DIR__ . '/../models/Like.php'; // Importe o Model Like (vamos criá-lo a seguir)

class LikeController {
    private $pdo;
    private $like; 

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->like = new Like($pdo);
    }

    public function curtir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario_id'])) {
            $usuario_id = $_SESSION['usuario_id'];
            $post_id = $_POST['post_id']; 

            // Verifica se o usuário já curtiu o post
            if ($this->like->jaCurtiu($usuario_id, $post_id)) {
                $this->like->descurtir($usuario_id, $post_id);
            } else {
                $this->like->curtir($usuario_id, $post_id);
            }
        }

        // Redireciona para a página anterior (ou para onde você desejar)
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit();
    }
}