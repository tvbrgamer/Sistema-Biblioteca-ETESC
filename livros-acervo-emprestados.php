<?php

/** @var $pdo \PDO */
require_once "database.php";

$search = $_GET['pesquisa'] ?? '';
$limit = $_GET['limit'] ?? 25;
$start = $_GET['start'] ?? 0;
$ordem = $_GET['ordem'] ?? "ASC";
$origem = "livros-acervo-emprestados.php";
$startelimit = $start + $limit;

$parametro = "?" . "pesquisa=" . $search . "&" . "limit=" . $limit . "&" . "start=" . $start . "&" . "ordem=" . $ordem;

if ($search) {
  if ($ordem == "DESC") {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados >= 1 AND (Autor LIKE :autor OR titulo LIKE :titulo) ORDER BY ID DESC LIMIT :start , :limit");
  } else {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados >= 1 AND (Autor LIKE :autor OR titulo LIKE :titulo) LIMIT :start , :limit");
  }
  $statement->bindValue(":autor", "%$search%");
  $statement->bindValue(":titulo", "%$search%");
} else {
  if ($ordem == "DESC") {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados >= 1 ORDER BY ID DESC LIMIT :start , :limit ");
  } else {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados >= 1 LIMIT :start , :limit ");
  }
}

$statement->bindValue(":start", $start, PDO::PARAM_INT);
$statement->bindValue(":limit", $limit, PDO::PARAM_INT);
$statement->execute();

$livros = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Acervo-emprestados</title>
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

  <link rel="stylesheet" href="css/style.css" />
  <link rel="stylesheet" href="css/acervo.css" />

  <link href="css/bootstrap.css" rel="stylesheet">

  <script defer type="text/javascript" src="js/acervo.js"></script>
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
        <li><a href="livros-acervo-emprestados.php">Livros emprestados</a></li>
        <li><a href="alunos.php">Alunos</a></li>
    </nav>
  </header>


  <section class="btn-section">
    <form class="query__form" method="get">

      <div class="query__search">
        <input type="search" class="form-control" name="pesquisa" value="<?php echo $search; ?>" placeholder="Pesquisar Nome do Livro/Autor" autocomplete="off">
        <div class="query__btns" style="display: flex;justify-content:space-between">
          <button class="btn btn-success shadow" type="submit">Pesquisar Livros</button>

          <a href="livros-acervo.php" class="btn btn-outline-secondary shadow">Limpar campos</a>

        </div>

        <section class="selecao-section">

          <form class="paginacao" method="GET">

            <div id="LPP" style="width: 200px;">

              <h6> Livros por página:</h6>
              <select id="select" name="limit">
                <option value="25" <?php if ($limit == 25) echo "selected"; ?>>25</option>
                <option value="50" <?php if ($limit == 50) echo "selected"; ?>>50</option>
                <option value="100" <?php if ($limit == 100) echo "selected"; ?>>100</option>
                <option value="250" <?php if ($limit == 250) echo "selected"; ?>>250</option>
                <option value="500" <?php if ($limit == 500) echo "selected"; ?>>500</option>
              </select>
            </div>
            <div id="Ordem" style="width:200px;">

              <h6> Ordem de IDs(#):</h6>
              <select id="ordem" name="ordem">
                <option value="ASC" <?php if ($ordem == "ASC") echo "selected"; ?>>Crescente</option>
                <option value="DESC" <?php if ($ordem == "DESC") echo "selected"; ?>>Decrescente</option>
              </select>

            </div>
        </section>

        <div id="paginacao">
          <button class="btn btn-success shadow" type="submit" name="start" value="<?php if ($start <= $limit) {
                                                                                      echo $start = 0;
                                                                                    } else {
                                                                                      echo $start -= $limit;
                                                                                    } ?>"><abbr title="Página anterior">Anterior</abbr></button>

          <button class="btn btn-success shadow" name="start" type="submit" value="0"><abbr title="Inicio ou Final dos id(#)">Inicio/Fim</abbr></button>

          <button class="btn btn-success shadow" name="start" type="submit" value="<?php echo $startelimit ?>"><abbr title="Próxima página">Próximo</abbr></button>
        </div>
    </form>

  </section>

  </form>
  </section>

  <section class="livros-section">
    <table class="table">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Autor</th>
          <th scope="col">Titulo</th>
          <th scope="col">Assunto</th>
          <th scope="col">Classificação</th>
          <th scope="col">Situação</th>
          <th scope="col">Quantidade</th>
          <th scope="col">Emprestado</th>
          <th scope="col">Alunos com o Livro</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($livros as $i => $livro) : ?>
          <tr>
            <td><b><?php echo $livro['id'] ?></b></td>
            <td><?php echo $livro['Autor'] ?></td>
            <td><?php echo $livro['titulo'] ?></td>
            <td><?php echo $livro['Assunto'] ?></td>
            <td><?php echo $livro['Classificacao'] ?></td>
            <td><?php echo $livro['Situacao'] ?></td>
            <td><?php echo $livro['Quantidade'] ?></td>
            <td><?php echo $livro['Emprestados'] ?></td>
            <td>
              <form action="alunos.php" method="post"><button type="submit" name="id_livro" value="<?php echo $livro['id'] ?>" class="btn btn-sm btn-success shadow"><abbr title="Ver todos os alunos com esse livro">Mostrar</abbr></button></form>
            </td>

            <td style="white-space: nowrap;"></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</body>

</html>