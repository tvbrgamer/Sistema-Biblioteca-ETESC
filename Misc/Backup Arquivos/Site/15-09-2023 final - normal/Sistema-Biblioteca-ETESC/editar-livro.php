<?php

/** @var $pdo \PDO */
require_once "database.php";


$id = $_GET['id'] ?? null;

//Puxa os Parâmetros
$Parametros = $_GET['Parametro'] ?? null;

$location = "Location:livros-acervo.php" . $Parametros . "&tipo=edit_livro" . "#a" . $id;

if (!$id) {
  header("Location: livros-acervo.php");
  exit;
}

$statement = $pdo->prepare('SELECT * FROM livros WHERE id = :id');
$statement->bindValue(":id", $id);
$statement->execute();

$livro = $statement->fetch(PDO::FETCH_ASSOC);


$autor = $livro['Autor'];
$titulo = $livro['titulo'];
$assunto = $livro['Assunto'];
$classificacao = $livro['Classificacao'];
$quantidade = $livro['Quantidade'];
echo $livro['titulo'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $autor = $_POST['autor'];
  $titulo = $_POST['titulo'];
  $assunto = $_POST['assunto'];
  $classificacao = $_POST['classificacao'];
  $quantidade = $_POST['quantidade'];

  $statement = $pdo->prepare("UPDATE livros SET Autor = :autor, titulo = :titulo, Assunto = :assunto,
                                    Classificacao = :classificacao, Quantidade = :quantidade WHERE id = :id");

  $statement->bindValue(':autor', $autor);
  $statement->bindValue(':titulo', $titulo);
  $statement->bindValue(':assunto', $assunto);
  $statement->bindValue(':classificacao', $classificacao);
  $statement->bindValue(':quantidade', $quantidade);
  $statement->bindValue(':id', $id);
  $statement->execute();

  redirect($location);
}

function redirect($location)
{
  header($location);
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
        <li><a href="livros-acervo-emprestados.php">Livros emprestados</a></li>
        <li><a href="alunos.php">Alunos</a></li>
    </nav>
  </header>

  <form class="cadastro-section" method="POST">
    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Autor </span>
      <input type="text" name="autor" value="<?php echo $autor; ?>" class="form-control" placeholder="Autor" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Título</span>
      <input type="text" name="titulo" value="<?php echo $titulo; ?>" class="form-control" placeholder="Título" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Assunto</span>
      <input type="text" name="assunto" value="<?php echo $assunto; ?>" class="form-control" placeholder="Assunto" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Codigo</span>
      <input type="text" name="classificacao" value="<?php echo $classificacao; ?>" class="form-control" placeholder="Codigo" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
      <span class="input-group-text" id="basic-addon1">Quantidade</span>
      <input type="text" name="quantidade" value="<?php echo $quantidade; ?>" class="form-control" placeholder="Quantidade" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
    <button type="submit" class="btn btn-success">Editar</button>
  </form>
</body>

</html>