<?php

$id = $_POST['id'] ?? null;
// Quantidade de livros já emprestados
$QTDE = $_POST['QTDEmprestado'] ?? null;
// Quantidade de livros emprestados no final
$QTDEFinal = $QTDE + 1;
// Quantidade disponivel
$QTD = $_POST['QTD'] ?? null;

$origem = $_POST['origem'] ?? null;

//Puxa os Parâmetros
$Parametros = $_POST['Parametro'] ?? null;

$location = "Location:" . $origem . $Parametros . "#a" . $id;

// checar se id foi "chamado"
if (!$id) {
    header("Location: livros-acervo.php");
    exit;
}

/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare('SELECT * FROM livros WHERE id = :id');
$statement->bindValue(":id", $id);
$statement->execute();

$livro = $statement->fetch(PDO::FETCH_ASSOC);

if ($QTD >= $QTDEFinal) {

    $statement2 = $pdo->prepare('UPDATE livros SET Situacao = :situacao , Emprestados = :qtdef WHERE id = :id ');
    $statement2->bindValue(":id", $id);
    $statement2->bindValue(":situacao", "Emprestado");
    $statement2->bindValue(":qtdef", $QTDEFinal);

    $statement2->execute();
}
header("$location");
exit;