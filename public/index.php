<?php
require __DIR__ . '/../app/Controllers/ProdutoController.php';
require __DIR__ . '/../app/Controllers/CarrinhoController.php';
require __DIR__ . '/../app/Controllers/LoginController.php'; // 👈 novo
require __DIR__ . '/../app/Models/Produto.php';

use App\Controllers\ProdutoController;
use App\Controllers\CarrinhoController;
use App\Controllers\LoginController;

$rota = $_GET['rota'] ?? 'home';

switch ($rota) {
    case 'home':
        $controller = new ProdutoController();
        $controller->index();
        break;

    case 'adicionarCarrinho':
        $controller = new CarrinhoController();
        $controller->adicionar();
        break;

    case 'carrinho':
        $controller = new CarrinhoController();
        $controller->index();
        break;

    case 'removerCarrinho':
        $controller = new CarrinhoController();
        $controller->remover();
        break;

    case 'alterarQuantidade':
        $controller = new CarrinhoController();
        $controller->alterarQuantidade();
        break;

    case 'finalizarPedido':
        $controller = new CarrinhoController();
        $controller->finalizarPedido();
        break;

    case 'pedidos':
        $controller = new CarrinhoController();
        $controller->pedidos();
        break;

    case 'refazerPedido':
        $controller = new CarrinhoController();
        $controller->refazerPedido();
        break;

    case 'removerPedido':
        $controller = new CarrinhoController();
        $controller->removerPedido();
        break;

    // 🔑 novas rotas de login/cadastro/logout
    case 'login':
        $controller = new LoginController();
        $controller->login();
        break;

    case 'cadastro':
        $controller = new LoginController();
        $controller->cadastro();
        break;

    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;

    default:
        echo "Página não encontrada!";
}
