<header>
    <h1> Gelatto &amp; Co.</h1>
    <nav>
        <a href="index.php">Loja</a>
        <a href="carrinho.php">Carrinho</a>
        <a href="dashboard.php">Admin</a>

        <?php if (isset($_SESSION['cliente_id'])): ?>
            <span>Olá, <?= htmlspecialchars($_SESSION['cliente_nome']) ?></span>
            <a href="sair.php">Sair</a>
        <?php else: ?>
            <a href="login.php">Entrar / Cadastrar</a>
        <?php endif; ?>
    </nav>
</header>