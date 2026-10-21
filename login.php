<?php
require 'Conexao/conexao.php';

// Quem já está logado não precisa ver esta tela
if (isset($_SESSION['cliente_id'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrar - Gelatto & Co.</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div id="mensagem"></div>

        <div class="duas-colunas">
            <form id="form-login">
                <h2>Entrar</h2>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha" required>
                <button type="submit">Entrar</button>
            </form>

            <form id="form-cadastro">
                <h2>Criar conta</h2>
                <input type="text" name="nome" placeholder="Nome" required>
                <input type="email" name="email" placeholder="E-mail" required>
                <input type="password" name="senha" placeholder="Senha (mín. 4 caracteres)" minlength="4" required>
                <button type="submit">Cadastrar</button>
            </form>
        </div>
    </div>

    <script src="JS/login.js"></script>
</body>
</html>