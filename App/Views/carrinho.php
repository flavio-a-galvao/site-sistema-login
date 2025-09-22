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

    <link rel="stylesheet" href="/teste/public/css/style.css?v=5">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .logo {
            width: 12%; /* maior que nas outras telas */
        }
        @media (max-width: 768px) {
            .logo { width: 40%; }
        }
    </style>
</head>
<body>

<nav class="navbar bg-danger">
    <div class="container-fluid d-flex justify-content-between align-items-center">

        <!-- Perfil à esquerda -->
        <div class="dropdown">
            <a href="#" class="btn btn-light dropdown-toggle perfil-btn" data-bs-toggle="dropdown">
                <i class="fas fa-user-circle fa-2x"></i>
            </a>
            <ul class="dropdown-menu">
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="dropdown-item">
                        👋 Olá, <b><?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></b>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="index.php?rota=logout"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                <?php else: ?>
                    <li><a class="dropdown-item" href="index.php?rota=login"><i class="fas fa-sign-in-alt"></i> Entrar</a></li>
                    <li><a class="dropdown-item" href="index.php?rota=cadastro"><i class="fas fa-user-plus"></i> Cadastrar</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <!-- Logo centralizada -->
        <img class="logo" src="/projeto-teste/public/imagens/logo.png" alt="Logo" style="height:120px; width:auto;">



        <!-- Botão Voltar à direita -->
        <a href="index.php?rota=home" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
