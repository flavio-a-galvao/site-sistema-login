<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$pedidos = $_SESSION['pedidos'] ?? [];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meus Pedidos - Leila Pães e Salgados</title>
    <link rel="stylesheet" href="/projeto-teste/public/css/style.css?v=7">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .pedido-img {
            width: 100%;
            max-height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .pedido-card {
            border-radius: 10px;
        }
        .pedido-meta {
            font-size: 0.95rem;
        }
        .pedido-actions {
            display: flex;
            gap: .5rem;
            justify-content: flex-end;
            align-items: center;
        }
    </style>
</head>
<body>
<nav class="navbar bg-danger">
    <div class="container-fluid">
        <a href="index.php?rota=home" class="btn btn-secondary btn-main"><i class="fas fa-arrow-left"></i> Voltar</a>
        <h5 class="m-0 text-white">Meus Pedidos</h5>
    </div>
</nav>

<main class="container my-4">
    <?php if (empty($pedidos)): ?>
        <p class="text-center text-muted">Você ainda não fez nenhum pedido.</p>
    <?php else: ?>
        <?php foreach (array_reverse($pedidos) as $pedido):
            $pedidoId = $pedido['id'] ?? '';
            $pedidoData = $pedido['data'] ?? '';
            $pedidoTotal = number_format($pedido['total'] ?? 0, 2, ',', '.');
            $itens = $pedido['itens'] ?? [];

            // garante que itens sejam array indexado
            if (!empty($itens) && (array_values($itens) === $itens) === false) {
                $itens = array_values($itens);
            }
        ?>
            <div class="card pedido-card shadow-sm mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="pedido-meta">
                        <i class="fas fa-calendar-alt"></i>
                        Pedido em <?php echo htmlspecialchars($pedidoData); ?>
                        <br>
                        <small class="text-muted">ID: <?php echo htmlspecialchars($pedidoId); ?></small>
                    </div>
                    <div class="fw-bold text-success">Total: R$ <?php echo $pedidoTotal; ?></div>
                </div>

                <div class="card-body">
                    <?php foreach ($itens as $itemIndex => $item): 
                        $nome = $item['produto'] ?? ($item['nome'] ?? 'Produto');
                        $preco = $item['preco'] ?? 0;
                        $qtd = $item['quantidade'] ?? 1;
                        $descricao = $item['descricao'] ?? '';
                        $subtotal = $preco * $qtd;
                        $imagens = [];

                        if (!empty($item['imagens']) && is_array($item['imagens'])) {
                            $imagens = $item['imagens'];
                        } elseif (!empty($item['imagem'])) {
                            $imagens[] = $item['imagem'];
                        } else {
                            $imagens[] = 'logo.png';
                        }

                        $carouselId = 'carousel-' . md5($pedidoId . '-' . $itemIndex . '-' . $nome);
                    ?>
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-4">
                                <?php if (count($imagens) > 1): ?>
                                    <div id="<?php echo $carouselId; ?>" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php foreach ($imagens as $i => $img): ?>
                                                <div class="carousel-item <?php echo ($i === 0) ? 'active' : ''; ?>">
                                                    <img src="/projeto-teste/public/imagens/<?php echo htmlspecialchars($img); ?>" class="d-block pedido-img" alt="<?php echo htmlspecialchars($nome); ?>">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Anterior</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#<?php echo $carouselId; ?>" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Próximo</span>
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <img src="/projeto-teste/public/imagens/<?php echo htmlspecialchars($imagens[0]); ?>" class="pedido-img rounded" alt="<?php echo htmlspecialchars($nome); ?>">
                                <?php endif; ?>
                            </div>

                            <div class="col-md-8">
                                <h6 class="card-title"><?php echo htmlspecialchars($nome); ?></h6>
                                <?php if ($descricao): ?>
                                    <p class="text-muted small"><?php echo htmlspecialchars($descricao); ?></p>
                                <?php endif; ?>
                                <p class="mb-1">Preço: <strong>R$ <?php echo number_format($preco, 2, ',', '.'); ?></strong></p>
                                <p class="mb-1">Quantidade: <strong><?php echo (int)$qtd; ?></strong></p>
                                <p class="fw-bold">Subtotal: R$ <?php echo number_format($subtotal, 2, ',', '.'); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="card-footer">
                    <div class="pedido-actions">
                        <form method="POST" action="index.php?rota=refazerPedido" style="display:inline;">
                            <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($pedidoId); ?>">
                            <button type="submit" class="btn btn-primary btn-main"><i class="fas fa-redo"></i> Refazer Pedido</button>
                        </form>

                        <form method="POST" action="index.php?rota=removerPedido" style="display:inline;">
                            <input type="hidden" name="pedido_id" value="<?php echo htmlspecialchars($pedidoId); ?>">
                            <button type="submit" class="btn btn-outline-danger btn-main"><i class="fas fa-trash-alt"></i> Excluir Pedido</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
