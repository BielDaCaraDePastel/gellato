<?php
require 'Conexao/conexao.php';

try {
    $st = $pdo->prepare('DELETE FROM produtos WHERE id = ?');
    $st->execute([$_POST['id'] ?? 0]);
    echo 'ok';
} catch (PDOException $e) {
    echo 'Não é possível excluir: o produto já foi vendido.';
}