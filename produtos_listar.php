<?php
require 'Conexao/conexao.php';

$sql = 'SELECT p.id, p.nome, p.preco, p.estoque, p.id_categoria, c.nome AS categoria
        FROM produtos p
        LEFT JOIN categorias c ON c.id = p.id_categoria
        ORDER BY p.id DESC';

echo json_encode($pdo->query($sql)->fetchAll());
