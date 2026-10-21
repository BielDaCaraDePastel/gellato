<?php require 'Conexao/conexao.php'; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho - Gelatto & Co.</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <h2>Seu carrinho</h2>
        <table>
            <thead><tr><th>Produto</th><th>Qtd</th><th>Subtotal</th></tr></thead>
            <tbody id="lista"></tbody>
        </table>
        <h3>Total: R$ <span id="total">0.00</span></h3>
        <button id="btn-finalizar">Finalizar compra</button>
        <div id="mensagem"></div>
    </div>

    <script src="JS/carrinho.js"></script>
</body>
</html>