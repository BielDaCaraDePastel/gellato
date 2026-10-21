<?php
require 'Conexao/conexao.php';

session_destroy();
header('Location: index.php');
exit;