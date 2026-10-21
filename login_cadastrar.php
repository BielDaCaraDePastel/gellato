<?php
require 'Conexao/conexao.php';

$nome  = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

// Validação no back-end
if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 4) {
    echo 'Preencha nome, um e-mail válido e uma senha de 4+ caracteres.';
    exit;
}

// E-mail já cadastrado?
$st = $pdo->prepare('SELECT id FROM clientes WHERE email = ?');
$st->execute([$email]);
if ($st->fetch()) {
    echo 'Este e-mail já está cadastrado.';
    exit;
}

$st = $pdo->prepare('INSERT INTO clientes (nome, email, senha) VALUES (?, ?, ?)');
$st->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);

session_regenerate_id(true);
$_SESSION['cliente_id']   = $pdo->lastInsertId();
$_SESSION['cliente_nome'] = $nome;

echo 'ok';