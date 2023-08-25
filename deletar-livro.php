<?php

$id = $_POST['id'] ?? null;

if (!$id) {
    header("Location: livros-acervo.php");
    exit;
}


/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare('DELETE FROM livros WHERE id = :id');
$statement->bindValue(":id", $id);
$statement->execute();

header("Location: livros-acervo.php?tipo=delete_livro");
exit;