<?php
require 'Conexao/conexao.php';

echo json_encode($pdo->query('SELECT id, nome FROM categorias ORDER BY nome')->fetchAll());