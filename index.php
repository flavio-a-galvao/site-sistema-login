<?php
// index.php (na raiz do projeto: C:\xampp\htdocs\2024\projeto-teste)

// Autoloader: Carrega as classes automaticamente
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

    if (file_exists($path)) {
        require_once $path;
    }
});

use App\Controllers\ProdutoController;
use App\Controllers\AuthController;

// Define o caminho base do seu projeto no XAMPP
$basePath = '/projeto-teste';

// Pega a URL e a limpa
$requestUri = $_SERVER['REQUEST_URI'];
$route = trim(substr($requestUri, strlen($basePath)), '/');

// Verifica se a rota solicitada é para um arquivo estático (CSS, JS, imagens, etc.)
$filePath = __DIR__ . '/' . $route;
if (file_exists($filePath) && !is_dir($filePath)) {
    // Se o arquivo existir, serve-o diretamente e encerra a execução
    if (strpos($route, '.css') !== false) {
        header('Content-Type: text/css');
    } elseif (strpos($route, '.js') !== false) {
        header('Content-Type: application/javascript');
    } elseif (strpos($route, '.png') !== false) {
        header('Content-Type: image/png');
    } elseif (strpos($route, '.jpg') !== false || strpos($route, '.jpeg') !== false) {
        header('Content-Type: image/jpeg');
    }
    readfile($filePath);
    exit;
}

// Mapeamento de rotas
$routes = [
    ''                  => ['controller' => ProdutoController::class, 'method' => 'index'],
    'login'             => ['controller' => AuthController::class, 'method' => 'login'],
    'cadastro'          => ['controller' => AuthController::class, 'method' => 'cadastro'],
    'logout'            => ['controller' => AuthController::class, 'method' => 'logout'],
    'produtos/grandes'  => ['controller' => ProdutoController::class, 'method' => 'grandes'],
    'produtos/pequenos' => ['controller' => ProdutoController::class, 'method' => 'pequenos'],
];

if (isset($routes[$route])) {
    $controllerName = $routes[$route]['controller'];
    $methodName = $routes[$route]['method'];
} else {
    // Rota não encontrada, exibe 404
    header("HTTP/1.0 404 Not Found");
    echo 'Página não encontrada';
    exit;
}

// Instancia o controlador e chama o método
$controller = new $controllerName();
$controller->$methodName();