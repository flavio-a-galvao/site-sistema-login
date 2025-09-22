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
    <title>Pedidos - Leila Pães e Salgados</title>
    <link rel="stylesheet" href="/teste/public/css/style.css?v=3">
    <link rel="stylesheet" href="/teste/public/css/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- 🔹 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <a href="index.php?rota=home">
                <img class="logo" src="/projeto-teste/public/imagens/logo.png" alt="Logo" height="50">
            </a>
            <div>
                <a href="index.php?rota=home" class="btn btn-link text-white">🏠 Home</a>
                <a href="index.php?rota=pedidos" class="btn btn-link text-white">📦 Pedidos</a>
                <a href="index.php?rota=carrinho" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Carrinho
                </a>
            </div>
            <div>
                <?php if (!empty($_SESSION['usuario'])): ?>
                    <span class="text-white me-2">👋 Olá, <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong></span>
                    <a href="index.php?rota=logout" class="btn btn-danger">🚪 Sair</a>
                <?php else: ?>
                    <a href="index.php?rota=login" class="btn btn-success">🔑 Login</a>
                    <a href="index.php?rota=cadastro" class="btn btn-warning">📝 Cadastro</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 🔹 Conteúdo -->
    <div class="container my-4">
        <h2 class="mb-4">📦 Meus Pedidos</h2>

        <?php if (!empty($pedidos)): ?>
            <ul class="list-group">
                <?php foreach ($pedidos as $pedido): ?>
                    <li class="list-group-item">
                        <strong>Pedido:</strong> <?= htmlspecialchars($pedido['id']); ?> <br>
                        <strong>Data:</strong> <?= $pedido['data']; ?> <br>
                        <strong>Total:</strong> R$ <?= number_format($pedido['total'], 2, ',', '.'); ?> <br>

                        <form method="POST" action="index.php?rota=refazerPedido" class="d-inline">
                            <input type="hidden" name="pedido_id" value="<?= htmlspecialchars($pedido['id']); ?>">
                            <button type="submit" class="btn btn-warning btn-sm">🔄 Refazer</button>
                        </form>

                        <form method="POST" action="index.php?rota=removerPedido" class="d-inline">
                            <input type="hidden" name="pedido_id" value="<?= htmlspecialchars($pedido['id']); ?>">
                            <button type="submit" class="btn btn-danger btn-sm">🗑 Remover</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="text-muted">Você ainda não fez nenhum pedido.</p>
        <?php endif; ?>
    </div>
</body>
</html>
