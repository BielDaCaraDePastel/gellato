<?php
require 'Conexao/conexao.php';

$produtos = $pdo->query('SELECT id, nome, preco FROM produtos WHERE estoque > 0 ORDER BY nome')->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelatto & Co.</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="vitrine">
        <?php foreach ($produtos as $p): ?>
            <article class="card">
                <div class="imagem">🍨</div>
                <h3><?= htmlspecialchars($p['nome']) ?></h3>
                <p class="preco">R$ <?= number_format($p['preco'], 2, ',', '.') ?></p>
                <button class="btn-add"
                        data-id="<?= $p['id'] ?>"
                        data-nome="<?= htmlspecialchars($p['nome']) ?>"
                        data-preco="<?= $p['preco'] ?>">
                    Adicionar ao Carrinho
                </button>
            </article>
        <?php endforeach; ?>
    </main>

    <script src="JS/carrinho.js"></script>
</body>
</html>