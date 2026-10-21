<?php
require 'Conexao/conexao.php';

// Relatório 1: faturamento total
$faturamento = $pdo->query('SELECT COALESCE(SUM(total), 0) FROM pedidos')->fetchColumn();

// Relatório 2: ranking de sabores mais vendidos
$ranking = $pdo->query(
    'SELECT p.nome, SUM(i.quantidade) AS qtd_vendida
     FROM itens_pedido i
     JOIN produtos p ON p.id = i.id_produto
     GROUP BY p.id, p.nome
     ORDER BY qtd_vendida DESC'
)->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gelatto & Co.</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <header>
        <h1> Painel Administrativo</h1>
        <nav><a href="index.php">Loja</a></nav>
    </header>

    <div class="container">
        <div id="mensagem"></div>

        <h2>Produtos</h2>
        <form id="form-produto">
            <input type="hidden" name="id">
            <input type="text" name="nome" placeholder="Nome do sorvete" required>
            <input type="number" name="preco" placeholder="Preço" step="0.01" min="0" required>
            <input type="number" name="estoque" placeholder="Estoque" min="0" required>
            <select name="id_categoria" id="select-categoria"></select>
            <button type="submit">Salvar</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Ações</th></tr></thead>
            <tbody id="tabela-produtos"></tbody>
        </table>

        <h2>Categorias</h2>
        <form id="form-categoria">
            <input type="hidden" name="id">
            <input type="text" name="nome" placeholder="Nome da categoria" required>
            <button type="submit">Salvar</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Nome</th><th>Ações</th></tr></thead>
            <tbody id="tabela-categorias"></tbody>
        </table>
                <h2>Clientes</h2>
        <form id="form-cliente">
            <input type="hidden" name="id">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="email" name="email" placeholder="E-mail" required>
            <input type="password" name="senha" placeholder="Senha (vazio = manter)">
            <button type="submit">Salvar</button>
        </form>
        <table>
            <thead><tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Ações</th></tr></thead>
            <tbody id="tabela-clientes"></tbody>
        </table>

        <h2>Relatórios de Gestão</h2>
        <h3>Faturamento total: R$ <?= number_format($faturamento, 2, ',', '.') ?></h3>
        <table>
            <tr><th>#</th><th>Sabor</th><th>Qtd. vendida</th></tr>
            <?php foreach ($ranking as $pos => $r): ?>
                <tr>
                    <td><?= $pos + 1 ?></td>
                    <td><?= htmlspecialchars($r['nome']) ?></td>
                    <td><?= $r['qtd_vendida'] ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>

    <script src="JS/crud.js"></script>
</body>
</html>