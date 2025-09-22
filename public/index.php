<?php
require __DIR__ . '/../app/Config/Database.php'; // ✅ adiciona isso
require __DIR__ . '/../app/Controllers/ProdutoController.php';
require __DIR__ . '/../app/Controllers/CarrinhoController.php';
require __DIR__ . '/../app/Controllers/LoginController.php';
require __DIR__ . '/../app/Models/Produto.php';
require __DIR__ . '/../app/Models/Usuario.php';

use App\Controllers\ProdutoController;
use App\Controllers\CarrinhoController;
use App\Controllers\LoginController;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$rota = $_GET['rota'] ?? 'home';

// 🔒 Função auxiliar: exige login
function exigirLogin() {
    if (!isset($_SESSION['usuario'])) {
        header("Location: index.php?rota=login");
        exit;
    }
}

switch ($rota) {
    case 'home':
        $controller = new ProdutoController();
        $controller->index();
        break;

    // 🔑 LOGIN
    case 'login':
        $controller = new LoginController();
        $controller->login();
        break;

    // 🔑 CADASTRO
    case 'cadastro':
        $controller = new LoginController();
        $controller->cadastro();
        break;

    // SAIR
    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;

    // 🛒 CARRINHO (somente logado)
    case 'adicionarCarrinho':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->adicionar();
        break;

    case 'carrinho':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->index();
        break;

    case 'removerCarrinho':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->remover();
        break;

    case 'alterarQuantidade':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->alterarQuantidade();
        break;

    case 'finalizarPedido':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->finalizarPedido();
        break;

    case 'pedidos':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->pedidos();
        break;

    case 'refazerPedido':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->refazerPedido();
        break;

    case 'removerPedido':
        exigirLogin();
        $controller = new CarrinhoController();
        $controller->removerPedido();
        break;

    default:
        echo "Página não encontrada!";
}
