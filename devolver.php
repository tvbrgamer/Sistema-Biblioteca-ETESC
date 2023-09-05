<?php

/** @var $pdo \PDO */
require_once "database.php";


$id_aluno = $_GET['id_aluno'] ?? null;
$id_livro = $_GET['id_livro'] ?? null;

$tipo = "tipo=devolvido";

//Puxa os Parâmetros
$dados = rawurlencode($_GET['dados'] ?? "nada");

$location = "alunos.php" ."?" . "dados=" . $dados . "&" . $tipo;

$none ="";

if (!$id_aluno) {
    header("Location:" . $location);
    exit;
}


/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare("UPDATE alunos SET id_livro = :id_livro, data_emprestimo = :data_emprestimo, data_devolucao = :data_devolucao WHERE id_aluno = :id_aluno");

$statement->bindValue(':id_aluno', $id_aluno);
$statement->bindValue(':id_livro',$none, PDO::PARAM_NULL);
$statement->bindValue(':data_emprestimo',$none, PDO::PARAM_NULL);
$statement->bindValue(':data_devolucao',$none, PDO::PARAM_NULL);
$statement->execute();



$statement2 = $pdo->prepare('SELECT * FROM livros WHERE id = :id');
$statement2->bindValue(":id", $id_livro);
$statement2->execute();

$livro = $statement2->fetch(PDO::FETCH_ASSOC);

$QTDEFinal = ($livro['Emprestados'] - 1 );


$statement3 = $pdo->prepare('UPDATE livros SET Situacao = :situacao , Emprestados = :qtdef WHERE id = :id ');

if ($QTDEFinal == 0) {
    $statement3->bindValue(":situacao", "Acervo");
} else {
    $statement3->bindValue(":situacao", "Emprestado");
}
$statement3->bindValue(":id", $id_livro);
$statement3->bindValue(":qtdef", $QTDEFinal);
$statement3->execute();

header("Location:" . $location);
exit;