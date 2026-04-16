<?php

//Mude as credenciais de acesso ao banco de dados conforme necessário

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=sistema_biblioteca', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
