<?php

require_once __DIR__ . '/../models/Follower.php'; 

class FollowerController {
    private $pdo;
    private $follower; 

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->follower = new Follower($pdo);
    }

    public function seguir() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['usuario_id'])) {
            $seguidor_id = $_SESSION['usuario_id']; 
            $usuario_id = $_POST['usuario_id']; 

            // Verifica se o usuário está tentando se seguir
            if ($seguidor_id == $usuario_id) {
                $_SESSION['error'] = "Você não pode seguir você mesmo!"; 
            } else {
                // Verifica se já está seguindo
                if ($this->follower->estaSeguindo($seguidor_id, $usuario_id)) {
                    $this->follower->deixarDeSeguir($seguidor_id, $usuario_id);
                } else {
                    $this->follower->seguir($seguidor_id, $usuario_id);
                }
            }
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit();
    }
}