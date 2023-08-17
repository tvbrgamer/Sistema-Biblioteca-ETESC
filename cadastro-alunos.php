<?php

/** @var $pdo \PDO */
require_once "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_aluno = $_POST['nome_aluno'];
    $turma_aluno = $_POST['turma_aluno'];
    $telefone_aluno = $_POST['telefone_aluno'];

    $statement = $pdo->prepare("INSERT INTO alunos (nome_aluno,turma_aluno,telefone_aluno) VALUES(:nome_aluno,:turma_aluno,:telefone_aluno)");

    $statement->bindValue(':nome_aluno', $nome_aluno);
    $statement->bindValue(':turma_aluno', $turma_aluno);
    $statement->bindValue(':telefone_aluno', $telefone_aluno);
    $statement->execute();

    redirect("alunos.php");
}

function redirect($url)
{
  header('Location: ' . $url);
  die();
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Acervo</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/acervo.css" />

    <link href="css/bootstrap.css" rel="stylesheet">
</head>

<body>

    <header class="header">
        <div class="logo-div">
            <a href="index.php">
                <img src="img/logoFaetec.png" alt="" />
                <img class="etesc" src="img/logo-etesc.png" alt="" />
                <img src="img/logoFaetec.png" alt="" />
            </a>
        </div>

        <nav class="nav">
            <ul>
                <li><a href="index.php">Início</a></li>
                <li><a href="livros-acervo.php">Catálogo</a></li>
        </nav>
    </header>

    <form class="cadastro-section" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nome </span>
            <input type="text" name="nome_aluno" placeholder="Insira o nome" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Turma</span>
            <input type="text" name="turma_aluno" placeholder="Insira a turma:" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Telefone</span>
            <input type="text" name="telefone_aluno" placeholder="Insira o telefone:" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
        <button type="submit" class="btn btn-success">Editar</button>
    </form>
</body>

</html>