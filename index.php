<?php

include 'produtos.php';
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Leila Pães e Salgados</title>
  <link rel="stylesheet" href="css/style.css?v=3">
  <link rel="stylesheet" href="css/aos.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
  <nav class="navbar bg-body-tertiary">
  <div class="container-fluid">

    <img class="logo" src="imagens/logo.png" alt="">

    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <img class="logo2" src="imagens/logo.png" alt="">
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="contato.php">Contato</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Salgados
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="minis.php">Minis</a></li>
              <li><a class="dropdown-item" href="grandes.php">Grandes</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>

<main>

  <img class="wallpaper" src="imagens/wallpaper2.jpg" alt="Descrição da imagem" width="100%">

  <h2 class="text-center" data-aos="flip-left">Entre em contato com a gente</h2>

  <div class="container" data-aos="flip-left">
    <a href="https://wa.me/5544998086959" class="whatsapp-button" target="_blank">
      <i class="fab fa-whatsapp"></i> Entre em Contato
    </a>
  </div>

  <h2 class="text-center" data-aos="flip-left">Nosso cardapio</h2>

 <div class="card-container">
        <?php foreach ($salgadosGrandes as $salgado): ?>
            <div class="card" data-aos="flip-left">
                <img src="<?php echo $salgado['imagem']; ?>" class="card-img-top" alt="<?php echo $salgado['nome']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $salgado['nome']; ?></h5>
                    <p class="card-text"><?php echo $salgado['descricao']; ?></p>
                    <p class="card-price">R$ <?php echo number_format($salgado['preco'], 2, ',', '.'); ?></p>
                    <div class="container">
                        <a href="https://wa.me/5544998086959" class="whatsapp-button" target="_blank">
                            <i class="fab fa-whatsapp"></i> Entre em Contato
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <?php foreach ($salgadosPequenos as $salgado): ?>
            <div class="card" data-aos="flip-left">
                <img src="<?php echo $salgado['imagem']; ?>" class="card-img-top" alt="<?php echo $salgado['nome']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $salgado['nome']; ?></h5>
                    <p class="card-text"><?php echo $salgado['descricao']; ?></p>
                    <p class="card-price">R$ <?php echo number_format($salgado['preco'], 2, ',', '.'); ?></p>
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <script src="js/jquery-1.11.3.min.js"></script>
  <script src="js/aos.js"></script>
  <script>
    AOS.init();
  </script>
    <!-- Aqui terminam seus outros scripts -->
  <script src="js/aos.js"></script>
  <script>
    AOS.init();
  </script>

  <!-- 👇 ETAPA 1 COMEÇA AQUI -->
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
  <!-- 👆 ETAPA 1 TERMINA AQUI -->

</body>
</html>

</body>
</html>
