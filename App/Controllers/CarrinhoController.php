<?php
namespace App\Controllers;

use App\Models\Produto;
use Config\Database;

class CarrinhoController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // ✅ Verifica se usuário está logado
    private function verificarLogin()
    {
        if (empty($_SESSION['usuario'])) {
            header('Location: index.php?rota=login');
            exit;
        }
    }

    // Exibe carrinho
    public function index()
    {
        $this->verificarLogin();
        $carrinho = $_SESSION['carrinho'] ?? [];
        require __DIR__ . '/../Views/carrinho.php';
    }

    // Adiciona produto ao carrinho
    public function adicionar()
    {
        $this->verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?rota=home');
            exit;
        }

        $nome  = trim($_POST['produto'] ?? '');
        $preco = floatval($_POST['preco'] ?? 0);

        if ($nome === '') {
            header('Location: index.php?rota=home');
            exit;
        }

        // Busca imagem e descrição no catálogo
        $imagem = '';
        $descricao = '';
        foreach (Produto::getAll() as $p) {
            if ($p->nome === $nome) {
                $imagem    = $p->imagem ?? '';
                $descricao = $p->descricao ?? '';
                break;
            }
        }

        $_SESSION['carrinho'] ??= [];

        if (isset($_SESSION['carrinho'][$nome])) {
            $_SESSION['carrinho'][$nome]['quantidade']++;
        } else {
            $_SESSION['carrinho'][$nome] = [
                'produto'   => $nome,
                'preco'     => $preco,
                'quantidade'=> 1,
                'imagem'    => $imagem,
                'descricao' => $descricao
            ];
        }

        header('Location: index.php?rota=carrinho');
        exit;
    }

    // Remove produto do carrinho
    public function remover()
    {
        $this->verificarLogin();

        $produto = $_POST['produto'] ?? $_GET['produto'] ?? null;

        if ($produto && isset($_SESSION['carrinho'][$produto])) {
            unset($_SESSION['carrinho'][$produto]);
        }

        header('Location: index.php?rota=carrinho');
        exit;
    }

    // Altera quantidade
    public function alterarQuantidade()
    {
        $this->verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?rota=carrinho');
            exit;
        }

        $produto = $_POST['produto'] ?? null;
        $acao    = $_POST['acao'] ?? null; // inc ou dec

        if ($produto && isset($_SESSION['carrinho'][$produto])) {
            if ($acao === 'inc') {
                $_SESSION['carrinho'][$produto]['quantidade']++;
            } elseif ($acao === 'dec') {
                $_SESSION['carrinho'][$produto]['quantidade']--;
                if ($_SESSION['carrinho'][$produto]['quantidade'] <= 0) {
                    unset($_SESSION['carrinho'][$produto]);
                }
            }
        }

        header('Location: index.php?rota=carrinho');
        exit;
    }

    // Finaliza pedido
    public function finalizarPedido()
    {
        $this->verificarLogin();

        if (empty($_SESSION['carrinho'])) {
            header('Location: index.php?rota=carrinho');
            exit;
        }

        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += ($item['preco'] ?? 0) * ($item['quantidade'] ?? 1);
        }

        $_SESSION['pedidos'] ??= [];

        // 🔑 pedido agora tem usuario_id
        $_SESSION['pedidos'][] = [
            'id'         => uniqid('pedido_', true),
            'usuario_id' => $_SESSION['usuario']['id'],
            'itens'      => $_SESSION['carrinho'],
            'data'       => date('d/m/Y H:i:s'),
            'total'      => $total
        ];

        $_SESSION['carrinho'] = []; // limpa carrinho

        header('Location: index.php?rota=pedidos');
        exit;
    }

    // Lista pedidos do usuário logado
    public function pedidos()
    {
        $this->verificarLogin();

        $todosPedidos = $_SESSION['pedidos'] ?? [];
        $usuarioId = $_SESSION['usuario']['id'];

        // Filtra apenas os pedidos do usuário logado
        $pedidos = array_filter($todosPedidos, fn($p) => $p['usuario_id'] === $usuarioId);

        require __DIR__ . '/../Views/pedidos.php';
    }

    // Refazer pedido
    public function refazerPedido()
    {
        $this->verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?rota=pedidos');
            exit;
        }

        $pedido_id = $_POST['pedido_id'] ?? null;
        if (!$pedido_id) {
            header('Location: index.php?rota=pedidos');
            exit;
        }

        foreach ($_SESSION['pedidos'] ?? [] as $idx => $p) {
            if (!empty($p['id']) && $p['id'] === $pedido_id && $p['usuario_id'] === $_SESSION['usuario']['id']) {
                $_SESSION['carrinho'] = $p['itens'];
                unset($_SESSION['pedidos'][$idx]);
                $_SESSION['pedidos'] = array_values($_SESSION['pedidos']);
                break;
            }
        }

        header('Location: index.php?rota=carrinho');
        exit;
    }

    // Remove pedido
    public function removerPedido()
    {
        $this->verificarLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?rota=pedidos');
            exit;
        }

        $pedido_id = $_POST['pedido_id'] ?? null;
        if (!$pedido_id) {
            header('Location: index.php?rota=pedidos');
            exit;
        }

        foreach ($_SESSION['pedidos'] ?? [] as $idx => $p) {
            if (!empty($p['id']) && $p['id'] === $pedido_id && $p['usuario_id'] === $_SESSION['usuario']['id']) {
                unset($_SESSION['pedidos'][$idx]);
                $_SESSION['pedidos'] = array_values($_SESSION['pedidos']);
                break;
            }
        }

        header('Location: index.php?rota=pedidos');
        exit;
    }
}
