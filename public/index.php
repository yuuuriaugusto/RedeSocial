<?php

// Inicia a sessão
session_start();

// Inclui o arquivo de configuração do banco de dados
require_once __DIR__ . '/../config/database.php';

// Inclui os controllers
require_once __DIR__ . '/../controllers/AuthController.php';
// ... outros controllers

// Crie um array para mapear as rotas (simplificado)
$routes = [
    '/' => ['controller' => 'HomeController', 'action' => 'index'], // Página inicial
    '/login' => ['controller' => 'AuthController', 'action' => 'login'],
    '/signup' => ['controller' => 'AuthController', 'action' => 'signup'],
    '/register' => ['controller' => 'AuthController', 'action' => 'register'],
    '/login' => ['controller' => 'AuthController', 'action' => 'login'],
    '/authenticate' => ['controller' => 'AuthController', 'action' => 'authenticate'],
    '/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    '/' => ['controller' => 'PostController', 'action' => 'index'],
    '/criar-post' => ['controller' => 'PostController', 'action' => 'createPost'],
    '/curtir' => ['controller' => 'LikeController', 'action' => 'curtir'],
    '/perfil' => ['controller' => 'UserController', 'action' => 'profile'], // Rota para o perfil do usuário logado
    '/perfil/{id}' => ['controller' => 'UserController', 'action' => 'viewProfile'], // Rota para visualizar o perfil de outros usuários (com base no ID)
    '/seguir' => ['controller' => 'FollowerController', 'action' => 'seguir'],
    // ... outras rotas
];

// Obtém a URL atual
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Verifica se a rota existe
if (array_key_exists($url, $routes)) {
    $controllerName = $routes[$url]['controller'];
    $actionName = $routes[$url]['action'];

    // Instancia o Controller e chama a Action
    $controller = new $controllerName($pdo); // Passa a conexão PDO
    $controller->$actionName();

} else {
    // Rota não encontrada (404)
    http_response_code(404);
    echo "Página não encontrada!";
}