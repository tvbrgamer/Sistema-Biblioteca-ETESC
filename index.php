<?php

/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare("SELECT SUM(Quantidade) FROM livros");
$statement->execute();

$livrosQtdSoma = $statement->fetch(PDO::FETCH_NUM);

$statement2 = $pdo->prepare("SELECT COUNT(id) FROM livros");
$statement2->execute();

$livrosQtd = $statement2->fetch(PDO::FETCH_NUM);


$statement3 = $pdo->prepare("SELECT SUM(Emprestados) FROM livros");
$statement3->execute();

$livrosEmpQtd = $statement3->fetch(PDO::FETCH_NUM);


$statement4 = $pdo->prepare("SELECT COUNT(id_aluno) FROM alunos");
$statement4->execute();

$AlunosQtd = $statement4->fetch(PDO::FETCH_NUM);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sistema Biblioteca</title>
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

  <link rel="stylesheet" href="css/style.css" />
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
        <!--
        <li><a href="livros-acervo-emprestados.php">Livros emprestados</a></li>
        <li><a href="alunos.php">Alunos</a></li>
        -->
    </nav>
  </header>

  <section class="hero-section">

    <a href="livros-acervo.php" class="nsei">
      <div class="card">
        <img src="img/home-icon1.png" alt="">
        <h3>Títulos de Livros</h3>
        <p><?php echo $livrosQtd[0]; ?></p>
        <h3>Total de Livros</h3>
        <p><?php echo $livrosQtdSoma[0]; ?></p>
      </div>
    </a>

    <!--

    <a href="livros-acervo-emprestados.php" class="nsei">
      <div class="card">
        <img src="img/home-icon2.png" alt="home">

        <h3 style="margin-top: 50px;">Livros Emprestados</h3>
        <p><?php echo $livrosEmpQtd[0]; ?></p>

      </div>
    </a>

    <a href="alunos.php" class="nsei">
      <div class="card">
        <img src="img/aluno.png" alt="aluno">

        <h3 style="margin-top: 50px;">Total de Alunos</h3>
        <p><?php echo $AlunosQtd[0]; ?></p>

      </div>
    </a>

    -->

    </div>
  </section>
</body>

<style>
  body {
    overflow: hidden;
  }

  .nsei {
    height: 289.514px;
    width: 261.021;
    text-decoration: none;
    color: black
  }

  .nsei div.card {
    height: 289.514px;
    width: 261.021;
  }
</style>

</html>