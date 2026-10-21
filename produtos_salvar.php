<?php
require 'Conexao/conexao.php';

$id        = $_POST['id'] ?? '';
$nome      = trim($_POST['nome'] ?? '');
$preco     = $_POST['preco'] ?? '';
$estoque   = $_POST['estoque'] ?? '';
$categoria = ($_POST['id_categoria'] ?? '') ?: null;

// Validação no back-end
if ($nome === '' || !is_numeric($preco) || !is_numeric($estoque)) {
    echo 'Preencha nome, preço e estoque corretamente.';
    exit;
}

if ($id) {
    $st = $pdo->prepare('UPDATE produtos SET nome=?, preco=?, estoque=?, id_categoria=? WHERE id=?');
    $st->execute([$nome, $preco, $estoque, $categoria, $id]);
} else {
    $st = $pdo->prepare('INSERT INTO produtos (nome, preco, estoque, id_categoria) VALUES (?, ?, ?, ?)');
    $st->execute([$nome, $preco, $estoque, $categoria]);
}

echo 'ok';