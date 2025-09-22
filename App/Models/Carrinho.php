<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Carrinho</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Meu Carrinho</h2>
    <?php if (!empty($carrinho)): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php foreach ($carrinho as $produto => $dados): ?>
                    <?php $subtotal = $dados['preco'] * $dados['quantidade']; ?>
                    <?php $total += $subtotal; ?>
                    <tr>
                        <td><?= $produto ?></td>
                        <td>R$ <?= number_format($dados['preco'], 2, ',', '.') ?></td>
                        <td><?= $dados['quantidade'] ?></td>
                        <td>R$ <?= number_format($subtotal, 2, ',', '.') ?></td>
                        <td>
                            <a href="index.php?rota=removerCarrinho&produto=<?= urlencode($produto) ?>" class="btn btn-danger btn-sm">Remover</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h4>Total: R$ <?= number_format($total, 2, ',', '.') ?></h4>
    <?php else: ?>
        <p>Seu carrinho está vazio.</p>
    <?php endif; ?>
    <a href="index.php" class="btn btn-secondary">Voltar</a>
</div>
</body>
</html>
