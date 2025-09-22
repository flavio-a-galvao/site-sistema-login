<?php
namespace App\Controllers;

use App\Models\Produto;

class CarrinhoController
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🚀 Limpa pedidos antigos sem 'id'
        if (!empty($_SESSION['pedidos'])) {
            foreach ($_SESSION['pedidos'] as $idx => $p) {
                if (empty($p['id'])) {
                    unset($_SESSION['pedidos'][$idx]);
                }
            }
            $_SESSION['pedidos'] = array_values($_SESSION['pedidos']); // reindexa
        }
    }

    // Exibe carrinho
    public function index()
    {
        $carrinho = $_SESSION['carrinho'] ?? [];
        require __DIR__ . '/../Views/carrinho.php';
    }

    // Adiciona produto ao carrinho
    public function adicionar()
    {
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
        if (empty($_SESSION['carrinho'])) {
            header('Location: index.php?rota=carrinho');
            exit;
        }

        $total = 0;
        foreach ($_SESSION['carrinho'] as $item) {
            $total += ($item['preco'] ?? 0) * ($item['quantidade'] ?? 1);
        }

        $_SESSION['pedidos'] ??= [];

        // 🔑 sempre salva com ID único
        $pedido = [
            'id'    => uniqid('pedido_', true),
            'itens' => $_SESSION['carrinho'],
            'data'  => date('d/m/Y H:i:s'),
            'total' => $total
        ];

        $_SESSION['pedidos'][] = $pedido;

        $_SESSION['carrinho'] = []; // limpa carrinho

        header('Location: index.php?rota=pedidos');
        exit;
    }

    // Lista pedidos
    public function pedidos()
    {
        $pedidos = $_SESSION['pedidos'] ?? [];
        require __DIR__ . '/../Views/pedidos.php';
    }

    // Refazer pedido: joga pro carrinho e remove do histórico
    public function refazerPedido()
    {
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
            if (!empty($p['id']) && $p['id'] === $pedido_id) {
                $_SESSION['carrinho'] = $p['itens'];
                unset($_SESSION['pedidos'][$idx]);
                $_SESSION['pedidos'] = array_values($_SESSION['pedidos']);
                break;
            }
        }

        header('Location: index.php?rota=carrinho');
        exit;
    }

    // Remove pedido do histórico
    public function removerPedido()
    {
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
            if (!empty($p['id']) && $p['id'] === $pedido_id) {
                unset($_SESSION['pedidos'][$idx]);
                $_SESSION['pedidos'] = array_values($_SESSION['pedidos']);
                break;
            }
        }

        header('Location: index.php?rota=pedidos');
        exit;
    }
}
