<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$carrinho = $_SESSION['carrinho'] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho - Leila Pães e Salgados</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome (garante os ícones) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS inline para garantir que seja aplicado imediatamente -->
    <style>
        /* Container do card */
        .card {
            border-radius: 10px;
        }
        .card img {
            max-height: 180px;
            object-fit: cover;
        }

        /* ===== Botões circulares (quantidade/remover) ===== */
        .card .btn-circle {
            width: 56px !important;
            height: 56px !important;
            border-radius: 50% !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 0 !important;
            border: none !important;
            cursor: pointer !important;
            box-shadow: 0 6px 14px rgba(0,0,0,0.18) !important;
            transition: transform 0.14s ease, opacity 0.14s ease !important;
            background: #999 !important; /* fallback */
            color: #fff !important;
            font-size: 0 !important; /* reset, icone controla o tamanho */
        }

        .card .btn-circle i {
            font-size: 22px !important;   /* garante ícone grande */
            line-height: 1 !important;
            pointer-events: none !important;
            color: #fff !important;       /* default branco */
        }

        .card .btn-circle:hover {
            transform: scale(1.08) !important;
        }

        /* cores específicas (forçando com !important) */
        .card .btn-inc { background-color: #28a745 !important; } /* verde */
        .card .btn-dec { background-color: #ffc107 !important; } /* amarelo */
        .card .btn-del { background-color: #dc3545 !important; } /* vermelho */

        /* ícone do botão dec (amarelo) deve ficar escuro para contraste */
        .card .btn-dec i { color: #111 !important; }

        /* ===== Botões principais ===== */
        .actions-footer {
            margin-top: 1.5rem;
            display: flex;
            justify-content: center;
            gap: 12px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn-main {
            padding: 12px 26px !important;
            font-size: 16px !important;
            font-weight: 600 !important;
            border-radius: 10px !important;
            box-shadow: 0 6px 14px rgba(0,0,0,0.12) !important;
            transition: transform 0.14s ease !important;
        }

        .btn-main:hover {
            transform: translateY(-3px) !important;
        }

        /* Ajustes de responsividade */
        @media (max-width: 768px) {
            .card img { max-height: 140px; }
            .card .btn-circle { width: 48px !important; height: 48px !important; }
            .card .btn-circle i { font-size: 20px !important; }
            .btn-main { padding: 10px 18px !important; font-size: 15px !important; }
        }

        /* centraliza bem o total e a área de ações */
        .cart-total {
            margin-top: 22px;
            text-align: center;
        }
    </style>
</head>
<body>
<nav class="navbar bg-danger">
    <div class="container-fluid">
        <a href="index.php?rota=home" class="btn btn-secondary btn-main">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <h5 class="m-0 text-white">Carrinho</h5>
    </div>
</nav>

<main class="container my-4">
    <?php if (empty($carrinho)): ?>
        <p class="text-center text-muted">Seu carrinho está vazio.</p>
    <?php else: ?>
        <div class="row g-3">
            <?php $total = 0; ?>
            <?php foreach ($carrinho as $key => $item): ?>
                <?php
                    $nome = $item['produto'] ?? $key;
                    $preco = $item['preco'] ?? 0;
                    $qtd = $item['quantidade'] ?? 1;
                    $imagem = $item['imagem'] ?? '';
                    $descricao = $item['descricao'] ?? '';

                    $subtotal = $preco * $qtd;
                    $total += $subtotal;
                    // Ajuste de path de imagem: mantenha conforme seu projeto
                    $imagemUrl = $imagem ? '/projeto-teste/public/imagens/' . $imagem : '/projeto-teste/public/imagens/logo.png';
                ?>
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <img src="<?php echo htmlspecialchars($imagemUrl); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($nome); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo htmlspecialchars($nome); ?></h5>
                            <?php if ($descricao): ?>
                                <p class="card-text text-muted"><?php echo htmlspecialchars($descricao); ?></p>
                            <?php endif; ?>
                            <p class="mb-1">Preço: <strong>R$ <?php echo number_format($preco,2,',','.'); ?></strong></p>
                            <p class="mb-1">Quantidade: <strong><?php echo (int)$qtd; ?></strong></p>
                            <p class="fw-bold mt-auto">Subtotal: R$ <?php echo number_format($subtotal,2,',','.'); ?></p>

                            <!-- Botões redondos -->
                            <div class="mt-3 d-flex justify-content-center gap-3">
                                <form method="POST" action="index.php?rota=alterarQuantidade">
                                    <input type="hidden" name="produto" value="<?php echo htmlspecialchars($nome); ?>">
                                    <input type="hidden" name="acao" value="inc">
                                    <button type="submit" class="btn-circle btn-inc" aria-label="Adicionar 1">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>

                                <form method="POST" action="index.php?rota=alterarQuantidade">
                                    <input type="hidden" name="produto" value="<?php echo htmlspecialchars($nome); ?>">
                                    <input type="hidden" name="acao" value="dec">
                                    <button type="submit" class="btn-circle btn-dec" aria-label="Diminuir 1">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>

                                <form method="POST" action="index.php?rota=removerCarrinho">
                                    <input type="hidden" name="produto" value="<?php echo htmlspecialchars($nome); ?>">
                                    <button type="submit" class="btn-circle btn-del" aria-label="Remover">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="cart-total">
            <h4>Total: R$ <?php echo number_format($total,2,',','.'); ?></h4>
        </div>
    <?php endif; ?>

    <!-- Botões aparecem sempre -->
    <div class="actions-footer">
        <a href="index.php?rota=home" class="btn btn-secondary btn-main">
            <i class="fas fa-arrow-left"></i> Continuar Comprando
        </a>

        <a href="index.php?rota=pedidos" class="btn btn-primary btn-main">
            <i class="fas fa-list"></i> Meus Pedidos
        </a>

        <?php if (!empty($carrinho)): ?>
            <form method="POST" action="index.php?rota=finalizarPedido" style="display:inline-block;">
                <button type="submit" class="btn btn-success btn-main">
                    <i class="fas fa-check"></i> Finalizar Pedido
                </button>
            </form>
        <?php endif; ?>
    </div>
</main>

<!-- Bootstrap JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
