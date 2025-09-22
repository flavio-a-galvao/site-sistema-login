<?php if (!empty($_SESSION['erro'])): ?>
    <p style="color:red;"><?= $_SESSION['erro']; unset($_SESSION['erro']); ?></p>
<?php endif; ?>

<form method="POST" action="index.php?rota=autenticar">
    <label>Nome:</label>
    <input type="text" name="nome" required>
    <br>
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <br>
    <button type="submit">Entrar</button>
</form>

<a href="index.php?rota=cadastro">Cadastrar</a>
