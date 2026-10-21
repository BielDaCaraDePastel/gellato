<?php
require 'Conexao/conexao.php';

// Só cliente logado pode comprar
if (!isset($_SESSION['cliente_id'])) {
    echo 'login';
    exit;
}

// Chega como texto JSON
$itens = json_decode($_POST['itens'] ?? '', true);

// Validação no back-end
if (!is_array($itens) || empty($itens)) {
    echo 'Carrinho vazio.';
    exit;
}
$itens = array_map('intval', $itens);

try {
    $pdo->beginTransaction();

    // 1) Confere cada item e calcula o total com os preços do BANCO
    $total = 0;
    $precos = [];
    foreach ($itens as $id => $qtd) {
        $st = $pdo->prepare('SELECT nome, preco, estoque FROM produtos WHERE id = ?');
        $st->execute([$id]);
        $produto = $st->fetch();

        if (!$produto || $qtd <= 0) {
            throw new Exception('Item inválido.');
        }
        if ($produto['estoque'] < $qtd) {
            throw new Exception('Estoque insuficiente para ' . $produto['nome']);
        }

        $precos[$id] = $produto['preco'];
        $total += $produto['preco'] * $qtd;
    }

    // 2) Cria o pedido (cliente 1 = cliente de teste)
    $st = $pdo->prepare('INSERT INTO pedidos (id_cliente, total) VALUES (?, ?)');
    $st->execute([$_SESSION['cliente_id'], $total]);
    $idPedido = $pdo->lastInsertId();

    // 3) Cria os itens e dá baixa no estoque
    foreach ($itens as $id => $qtd) {
        $st = $pdo->prepare('INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)');
        $st->execute([$idPedido, $id, $qtd, $precos[$id]]);

        $st = $pdo->prepare('UPDATE produtos SET estoque = estoque - ? WHERE id = ?');
        $st->execute([$qtd, $id]);
    }

    $pdo->commit();
    echo 'ok';

} catch (Exception $e) {
    $pdo->rollBack();
    echo $e->getMessage();
}