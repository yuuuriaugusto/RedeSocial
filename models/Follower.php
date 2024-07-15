<?php

class Follower {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Verifica se um usuário está seguindo outro
    public function estaSeguindo($seguidor_id, $usuario_id) {
        $sql = "SELECT id FROM seguidores WHERE seguidor_id = :seguidor_id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':seguidor_id', $seguidor_id);
        $stmt->bindValue(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Adiciona o relacionamento de seguir
    public function seguir($seguidor_id, $usuario_id) {
        $sql = "INSERT INTO seguidores (seguidor_id, usuario_id) VALUES (:seguidor_id, :usuario_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':seguidor_id', $seguidor_id);
        $stmt->bindValue(':usuario_id', $usuario_id);
        return $stmt->execute();
    }

    // Remove o relacionamento de seguir
    public function deixarDeSeguir($seguidor_id, $usuario_id) {
        $sql = "DELETE FROM seguidores WHERE seguidor_id = :seguidor_id AND usuario_id = :usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':seguidor_id', $seguidor_id);
        $stmt->bindValue(':usuario_id', $usuario_id);
        return $stmt->execute();
    }
}