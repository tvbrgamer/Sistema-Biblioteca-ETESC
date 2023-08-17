<?php

/** @var $pdo \PDO */
require_once "database.php";


$id_aluno = $_GET['id_aluno'] ?? null;

//Puxa os Parâmetros
$Parametros = $_GET['Parametro'] ?? null;

$location = "alunos.php" . $Parametros . "#a" . $id_aluno;

$none ="";

if (!$id_aluno) {
    header("Location: alunos.php");
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

header("Location: alunos.php");
exit;