<?php

/** @var $pdo \PDO */
require_once "database.php";




if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // $imagem = $_POST['imagem'];
  $autor = $_POST['autor'];
  $titulo = $_POST['titulo'];
  $assunto = $_POST['assunto'];
  $classificacao = $_POST['classificacao'];
  $quantidade = $_POST['quantidade'];

  $statement = $pdo->prepare("INSERT INTO livros (Autor, titulo, Assunto, Classificacao, Quantidade) VALUES (:autor, :titulo, :assunto, :classificacao, :quantidade)");

  $statement->bindValue(':autor', $autor);
  $statement->bindValue(':titulo', $titulo);
  $statement->bindValue(':assunto', $assunto);
  $statement->bindValue(':classificacao', $classificacao);
  $statement->bindValue(':quantidade', $quantidade);
  $statement->execute();

  redirect("livros-acervo.php");
}

// echo '<pre>';
// var_dump($_POST);
// echo '</pre>';
// exit;

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

  <script type="text/javascript" src="js/sweetalert.js"></script>
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
      <span class="input-group-text" id="basic-addon1">Autor </span>
      <input type="text" name="autor" class="form-control" placeholder="Autor" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Título</span>
      <input type="text" name="titulo" class="form-control" placeholder="Título" aria-label="Username" aria-describedby="basic-addon1" autocomplete="off">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Assunto</span>
      <input type="text" name="assunto" class="form-control" placeholder="Assunto" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Código</span>
      <input type="text" name="classificacao" class="form-control" placeholder="Código" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Quantidade</span>
      <input type="text" name="quantidade" class="form-control" placeholder="Quantidade" aria-label="Username" aria-describedby="basic-addon1" autocomplete="off">
    </div>

    <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
    <button type="submit" class="btn btn-success">Cadastrar</button>
  </form>
</body>

</html>