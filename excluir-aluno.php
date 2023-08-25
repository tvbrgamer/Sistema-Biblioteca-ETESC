<?php

$id_aluno = $_GET['id_aluno'] ?? null;
$id_livro = $_GET['id_livro'] ?? null;

if (!$id_aluno) {
    header("Location: alunos.php");
    exit;
}


/** @var $pdo \PDO */
require_once "database.php";

if ($id_livro) {
    $statement = $pdo->prepare('SELECT * FROM livros WHERE id = :id');
    $statement->bindValue(":id", $id_livro);
    $statement->execute();

    $livro = $statement->fetch(PDO::FETCH_ASSOC);

    $QTDEFinal = ($livro['Emprestados'] - 1);

    $statement2 = $pdo->prepare('UPDATE livros SET Situacao = :situacao , Emprestados = :qtdef WHERE id = :id ');

    if ($QTDEFinal == 0) {
        $statement2->bindValue(":situacao", "Acervo");
    } else {
        $statement2->bindValue(":situacao", "Emprestado");
    }
    $statement2->bindValue(":id", $id_livro);
    $statement2->bindValue(":qtdef", $QTDEFinal);
    $statement2->execute();
}

$statement3 = $pdo->prepare('DELETE FROM alunos WHERE id_aluno = :id_aluno');
$statement3->bindValue(":id_aluno", $id_aluno);
$statement3->execute();

header("Location: alunos.php?tipo=delete_aluno");
exit;
