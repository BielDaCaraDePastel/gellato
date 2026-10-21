<?php
require 'Conexao/conexao.php';

echo json_encode($pdo->query('SELECT id, nome, email FROM clientes ORDER BY id DESC')->fetchAll());