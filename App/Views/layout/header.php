<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Projeto</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }
        header {
            background: #333;
            padding: 10px;
        }
        header nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        header nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        header nav a:hover {
            text-decoration: underline;
        }
        .user-info {
            color: #ccc;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <div>
            <a href="index.php?rota=home">🏠 Home</a>
            <a href="index.php?rota=carrinho">🛒 Carrinho</a>
            <a href="index.php?rota=pedidos">📦 Pedidos</a>
        </div>
        <div>
            <?php if (!empty($_SESSION['usuario'])): ?>
                <span class="user-info">Olá, <strong><?= htmlspecialchars($_SESSION['usuario']['nome']) ?></strong></span>
                <a href="index.php?rota=logout">🚪 Sair</a>
            <?php else: ?>
                <a href="index.php?rota=login">🔑 Login</a>
                <a href="index.php?rota=cadastro">📝 Cadastro</a>
            <?php endif; ?>
        </div>
    </nav>
</header>
<main style="padding:20px;">
