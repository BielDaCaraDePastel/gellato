<?php
require 'Conexao/conexao.php';

$id    = $_POST['id'] ?? '';
$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

// Validação no back-end
if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'Informe o nome e um e-mail válido.';
    exit;
}
if (!$id && strlen($senha) < 4) {
    echo 'A senha deve ter pelo menos 4 caracteres.';
    exit;
}

try {
    if ($id) {
        if ($senha !== '') {
            $st = $pdo->prepare('UPDATE clientes SET nome=?, email=?, senha=? WHERE id=?');
            $st->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT), $id]);
        } else {
            $st = $pdo->prepare('UPDATE clientes SET nome=?, email=? WHERE id=?');
            $st->execute([$nome, $email, $id]);
        }
    } else {
        $st = $pdo->prepare('INSERT INTO clientes (nome, email, senha) VALUES (?, ?, ?)');
        $st->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
    }
    echo 'ok';
} catch (PDOException $e) {
    echo 'Este e-mail já está cadastrado.';
}