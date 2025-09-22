<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leila Pães e Salgados</title>
    <link rel="stylesheet" href="/teste/public/css/style.css?v=3">
    <link rel="stylesheet" href="/teste/public/css/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- 🔹 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-between align-items-center">
            <!-- Logo -->
            <a href="index.php?rota=home">
                <img class="logo" src="/projeto-teste/public/imagens/logo.png" alt="Logo" height="50">
            </a>

            <!-- Links -->
            <div>
                <a href="index.php?rota=home" class="btn btn-link text-white">🏠 Home</a>
                <a href="index.php?rota=pedidos" class="btn btn-link text-white">📦 Pedidos</a>
                <a href="index.php?rota=carrinho" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Carrinho
                </a>
            </div>

            <!-- Login / Logout -->
            <div>
                <?php if (!empty($_SESSION['usuario'])): ?>
                    <span class="text-white me-2">
                        👋 Olá, <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong>
                    </span>
                    <a href="index.php?rota=logout" class="btn btn-danger">🚪 Sair</a>
                <?php else: ?>
                    <a href="index.php?rota=login" class="btn btn-success">🔑 Login</a>
                    <a href="index.php?rota=cadastro" class="btn btn-warning">📝 Cadastro</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- 🔹 Conteúdo principal -->
    <main>
        <img class="wallpaper" src="/projeto-teste/public/imagens/wallpaper2.jpg" 
             alt="Descrição da imagem" width="100%">

        <h2 class="text-center my-4" data-aos="flip-left">Nosso Cardápio</h2>

        <div class="card-container">
            <?php if (!empty($produtos)): ?>
                <?php foreach ($produtos as $index => $produto): ?>
                    <div class="card" data-aos="flip-left">
                        <img src="<?= $produto->getImagemUrl(); ?>" 
                             class="card-img-top" 
                             alt="<?= htmlspecialchars($produto->nome); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($produto->nome); ?></h5>
                            <p class="card-text"><?= htmlspecialchars($produto->descricao); ?></p>
                            <p class="card-price">R$ <?= number_format($produto->preco, 2, ',', '.'); ?></p>
                            <form method="POST" action="index.php?rota=adicionarCarrinho">
                                <input type="hidden" name="produto" value="<?= htmlspecialchars($produto->nome); ?>">
                                <input type="hidden" name="preco" value="<?= $produto->preco; ?>">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-cart-plus"></i> Adicionar ao carrinho
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">Nenhum produto cadastrado no momento.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- 🔹 Rodapé -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; <?= date("Y") ?> Leila Pães e Salgados. Todos os direitos reservados.</p>
            <a href="https://wa.me/5544998086959" class="whatsapp-icon" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </footer>

    <!-- 🔹 Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/projeto-teste/public/js/jquery-1.11.3.min.js"></script>
    <script src="/projeto-teste/public/js/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>
