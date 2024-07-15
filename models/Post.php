<?php

class Post {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Criar um novo post
    public function create($usuario_id, $texto, $imagem = null) {
        $sql = "INSERT INTO posts (usuario_id, texto, imagem) VALUES (:usuario_id, :texto, :imagem)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->bindValue(':texto', $texto);
        $stmt->bindValue(':imagem', $imagem); // Se houver imagem
        return $stmt->execute();
    }

    // Obter todos os posts (ordenados do mais recente para o mais antigo)
    public function getAllPosts() {
        $sql = "SELECT 
                    p.*, 
                    u.nome AS nome_usuario 
                FROM 
                    posts p 
                JOIN 
                    usuarios u ON p.usuario_id = u.id 
                ORDER BY 
                    p.criado_em DESC";

        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Obter todos os posts de um usuário específico
    public function getPostsByUserId($usuario_id) {
        $sql = "SELECT 
                    p.*, 
                    u.nome AS nome_usuario 
                FROM 
                    posts p 
                JOIN 
                    usuarios u ON p.usuario_id = u.id 
                WHERE 
                    p.usuario_id = :usuario_id
                ORDER BY 
                    p.criado_em DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
