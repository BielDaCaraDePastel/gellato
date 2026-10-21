<?php
require 'Conexao/conexao.php';

$email = trim($_POST['email'] ?? '');
$senha = $_POST['senha'] ?? '';

$st = $pdo->prepare('SELECT id, nome, senha FROM clientes WHERE email = ?');
$st->execute([$email]);
$cliente = $st->fetch();

if ($cliente && password_verify($senha, $cliente['senha'])) {
    session_regenerate_id(true);
    $_SESSION['cliente_id']   = $cliente['id'];
    $_SESSION['cliente_nome'] = $cliente['nome'];
    echo 'ok';
} else {
    echo 'E-mail ou senha incorretos.';
}