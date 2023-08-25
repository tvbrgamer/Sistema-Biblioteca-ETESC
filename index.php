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
    </nav>
  </header>

  <section class="hero-section">
    
  <a href="livros-acervo.php" style="text-decoration: none;color:black">
      <div class="card">
        <img src="img/home-icon1.png" alt="">
        <h3>Livros cadastrados</h3>
        <p><?php echo $livrosQtd[0]; ?></p>
        <h3>Quantidade de Livros</h3>
        <p><?php echo $livrosQtdSoma[0]; ?></p>
      </div>
    </a>

    <a href="livros-acervo-emprestados.php" style="height:289.514px;width:261.021;text-decoration: none;color:black">
      <div class="card" style="height:289.514px;width:261.021;">
        <img src="img/home-icon2.png" alt="">
        
        <h3 style="margin-top: 50px;">Livros Emprestados</h3>
        <p><?php echo $livrosEmpQtd[0]; ?></p>
        
      </div>
    </a>

    <a href="alunos.php" style="height:289.514px;width:261.021;text-decoration: none;color:black">
      <div class="card" style="height:289.514px;width:261.021;">
        <img src="" alt="">
        
        <h3 style="margin-top: 50px;">Alunos</h3>
        <p><?php echo "aaaaaaaaaaaaaa"; ?></p>
        
      </div>
    </a>

    </div>
  </section>
</body>

</html>