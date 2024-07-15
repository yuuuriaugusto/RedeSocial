<?php

class Like {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Verifica se o usuário já curtiu o post
    public function jaCurtiu($usuario_id, $post_id) {
        $sql = "SELECT id FROM curtidas WHERE usuario_id = :usuario_id AND post_id = :post_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->bindValue(':post_id', $post_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0; 
    }

    // Adiciona uma curtida
    public function curtir($usuario_id, $post_id) {
        $sql = "INSERT INTO curtidas (usuario_id, post_id) VALUES (:usuario_id, :post_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->bindValue(':post_id', $post_id);
        return $stmt->execute();
    }

    // Remove uma curtida
    public function descurtir($usuario_id, $post_id) {
        $sql = "DELETE FROM curtidas WHERE usuario_id = :usuario_id AND post_id = :post_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->bindValue(':post_id', $post_id);
        return $stmt->execute();
    }
}