<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leila Pães e Salgados</title>
    <link rel="stylesheet" href="/projeto-teste/public/css/style.css?v=3">
    <link rel="stylesheet" href="/projeto-teste/public/css/aos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar bg-body-tertiary">
        <div class="container-fluid">
            <img class="logo" src="/projeto-teste/public/imagens/logo.png" alt="">   
        </div>
    </nav>

    <main>
        <img class="wallpaper" src="/projeto-teste/public/imagens/wallpaper2.jpg" alt="Descrição da imagem" width="100%">

        <h2 class="text-center" data-aos="flip-left">Entre em contato com a gente</h2>
        <div class="container" data-aos="flip-left">
            <a href="https://wa.me/5544998086959" class="whatsapp-button" target="_blank">
                <i class="fab fa-whatsapp"></i> Entre em Contato
            </a>
        </div>

        <h2 class="text-center" data-aos="flip-left">Nosso cardápio</h2>
        <div class="card-container">
            <?php foreach ($produtos as $produto): ?>
                <div class="card" data-aos="flip-left">
                    <img src="/projeto-teste/public/imagens/<?php echo $produto->imagem; ?>" class="card-img-top" alt="<?php echo $produto->nome; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $produto->nome; ?></h5>
                        <p class="card-text"><?php echo $produto->descricao; ?></p>
                        <p class="card-price">R$ <?php echo number_format($produto->preco, 2, ',', '.'); ?></p>
                        <div class="container">
                            <a href="https://wa.me/5544998086959" class="whatsapp-button" target="_blank">
                                <i class="fab fa-whatsapp"></i> Entre em Contato
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Meu Site. Todos os direitos reservados.</p>
            <a href="https://wa.me/5544998086959" class="whatsapp-icon" target="_blank">
                <i class="fab fa-whatsapp"></i>
            </a>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/projeto-teste/public/js/jquery-1.11.3.min.js"></script>
    <script src="/projeto-teste/public/js/aos.js"></script>
    <script>
        AOS.init();
    </script>

    <div class="imagem-overlay" id="imagemOverlay">
        <span class="fechar-imagem" id="fecharImagem">&times;</span>
        <img id="imagemAmpliada" class="imagem-ampliada" src="" alt="Imagem ampliada">
    </div>

    <script>
        document.querySelectorAll('.card-img-top').forEach(imagem => {
            imagem.addEventListener('click', () => {
                const src = imagem.getAttribute('src');
                document.getElementById('imagemAmpliada').src = src;
                document.getElementById('imagemOverlay').style.display = 'flex';
            });
        });

        document.getElementById('fecharImagem').addEventListener('click', () => {
            document.getElementById('imagemOverlay').style.display = 'none';
        });

        document.getElementById('imagemOverlay').addEventListener('click', (e) => {
            if (e.target.id === 'imagemOverlay') {
                document.getElementById('imagemOverlay').style.display = 'none';
            }
        });
    </script>
</body>
</html>
