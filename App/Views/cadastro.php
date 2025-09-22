<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="max-width: 400px; width: 100%;">
        <h4 class="text-center mb-3">Cadastro</h4>

        <?php if (!empty($_SESSION['erro'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['erro']; unset($_SESSION['erro']); ?></div>
        <?php endif; ?>

        <form method="POST" action="index.php?rota=cadastro">
            <div class="mb-3">
                <label for="nome" class="form-label">Usuário</label>
                <input type="text" name="nome" id="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" name="senha" id="senha" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Cadastrar</button>
        </form>

        <p class="text-center mt-3">
            Já tem conta? <a href="index.php?rota=login">Faça login</a>
        </p>
    </div>
</body>
</html>
