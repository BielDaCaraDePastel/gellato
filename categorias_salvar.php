<?php
require 'Conexao/conexao.php';

$id   = $_POST['id'] ?? '';
$nome = trim($_POST['nome'] ?? '');

if ($nome === '') {
    echo 'Informe o nome da categoria.';
    exit;
}

if ($id) {
    $st = $pdo->prepare('UPDATE categorias SET nome=? WHERE id=?');
    $st->execute([$nome, $id]);
} else {
    $st = $pdo->prepare('INSERT INTO categorias (nome) VALUES (?)');
    $st->execute([$nome]);
}

echo 'ok';