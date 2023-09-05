<?php

/** @var $pdo \PDO */
require_once "database.php";

$tipo = $_GET['tipo'] ?? '';

$search = $_GET['pesquisa'] ?? '';
$limit = $_GET['limit'] ?? 25;
$start = $_GET['start'] ?? 0;
$ordem = $_GET['ordem'] ?? "ASC";
$origem = "livros-acervo.php";
$startelimit = $start + $limit;

$parametro = "?" . "pesquisa=" . $search . "&" . "limit=" . $limit . "&" . "start=" . $start . "&" . "ordem=" . $ordem;


if ($search) {

  if ($ordem == "ASC") {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Autor LIKE :autor OR titulo LIKE :titulo LIMIT $start , $limit");
  } else {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Autor LIKE :autor OR titulo LIKE :titulo ORDER BY ID DESC LIMIT $start , $limit ");
  }

  $statement->bindValue(":autor", "%$search%");
  $statement->bindValue(":titulo", "%$search%");
} else {
  if ($ordem == "ASC") {
    $statement = $pdo->prepare("SELECT * FROM livros LIMIT $start , $limit ");
  } else {
    $statement = $pdo->prepare("SELECT * FROM livros ORDER BY ID DESC LIMIT $start , $limit ");
  }
}

$statement->execute();
$livros = $statement->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Acervo</title>
  <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

  <link rel="stylesheet" href="css/acervo.css" />
  <link rel="stylesheet" href="css/style.css" />

  <link href="css/bootstrap.css" rel="stylesheet">

  <script defer type="text/javascript" src="js/acervo.js"></script>
  <script defer type="text/javascript" src="js/Notify.js"></script>
  <script type="text/javascript" src="js/sweetalert.js"></script>
</head>

<body <?php
      if ($tipo != "") {
        echo 'onload="Notify(\'' . $tipo . '\')"';
      } ?>>

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
        <li><a href="cadastro-livros.php">Catálogo</a></li>
    </nav>
  </header>


  <section class="btn-section">
    <form class="query__form" method="get">

      <div class="query__search">
        <input type="search" class="form-control" name="pesquisa" value="<?php echo $search; ?>" placeholder="Pesquisar Nome do Livro/Autor" autocomplete="off">
        <div class="query__btns">
          <button class="btn btn-success shadow" type="submit">Pesquisar Livros</button>

          <a href="livros-acervo.php" class="btn btn-outline-secondary shadow">Limpar campos</a>

          <a href="cadastro-livros.php" class="btn btn-primary shadow">Cadastrar Livro</a>

        </div>

        <section class="selecao-section">

          <form class="paginacao" method="GET">

            <div id="LPP">

              <h6> Livros por página:</h6>
              <select id="select" name="limit">
                <option value="25" <?php if ($limit == 25) echo "selected"; ?>>25</option>
                <option value="50" <?php if ($limit == 50) echo "selected"; ?>>50</option>
                <option value="100" <?php if ($limit == 100) echo "selected"; ?>>100</option>
                <option value="250" <?php if ($limit == 250) echo "selected"; ?>>250</option>
                <option value="500" <?php if ($limit == 500) echo "selected"; ?>>500</option>
              </select>
            </div>
            <div id="Ordem">

              <h6> Ordem de IDs(#):</h6>
              <select id="ordem" name="ordem" style="width: auto;">
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

    <!-- <section class="selecao-section">
        <form class="start&limit" method="GET">
          <h6 style="margin-left:28%">Insira a quantidade a mostrar:</h6>
          
          <h6 style="float:left" >Valor inicial:
          <input type="text" name="start" style="width:40px;text-align:center" value="<?php echo $start ?>"></h6>
          
          <h6 style="float:right">Nº de livros: 
          <input type="text" name="limit" style="width:40px;text-align:center" value="<?php echo $limit ?>" ></h6>
          
          <input type="submit" class="btn btn-outline-secondary shadow" style="width:100px;margin-left:12.5%" value="Enviar">
        </form> -->

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
          <th scope="col">Quantidade</th>
          <th scope="col">Emprestados</th>
          <th scope="col">Ação</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($livros as $i => $livro) : ?>
          <tr>
            <td><b><a id="<?php echo 'a' . $livro['id'] ?>"> <?php echo $livro['id'] ?></b></td>
            <td><?php echo $livro['Autor'] ?></td>
            <td><?php echo $livro['titulo'] ?></td>
            <td><?php echo $livro['Assunto'] ?></td>
            <td><?php echo $livro['Classificacao'] ?></td>
            <td><?php echo $livro['Quantidade'] ?></td>
            <td><?php echo $livro['Emprestados'] ?></td>

            <td style="white-space: nowrap;">
              <form id="editar<?php echo $livro['id'] ?>" action="editar-livro.php?id=<?php $livro['id'] ?>" method="get" style="display: inline-block">
                <input type="hidden" name="id" value="<?php echo $livro['id'] ?>">
                <input type="hidden" name="Parametro" value="<?php echo $parametro ?>">

                <button type="button" onclick="editaLivro(<?php echo $livro['id'] ?>);" class="btn btn-sm btn-outline-primary"><abbr title="Editar livro">Editar</abbr></button>
              </form>

              <form id="delete<?php echo $livro['id'] ?>" action="deletar-livro.php" method="post" style="display: inline-block">
                <input type="hidden" name="id" value="<?php echo $livro['id'] ?>">
                <button type="button" onclick="confirmarDelete(<?php echo $livro['id'] . ',' .  $livro['Emprestados'] ?>)" class="btn btn-sm btn-danger"><abbr title="Deletar 1 livro">Deletar</abbr></button>
              </form>

              <form id="empresta<?php echo $livro['id'] ?>" action="alunos.php" method="get" style="display: inline-block">

                <input type="hidden" name="dados" value="<?php echo 'id=' . $livro['id'] .
                                                            '&QTDEmprestado=' . $livro['Emprestados'] .
                                                            '&QTD=' . $livro['Quantidade'] .
                                                            '&origem=' . $origem .
                                                            '&Parametro=' . $parametro; ?>">

                <button type="button" onclick="Valida(<?php echo $livro['Quantidade'] ?> , <?php echo $livro['Emprestados'] ?>,<?php echo $livro['id'] ?> )" class="btn btn-sm btn-secondary"><abbr title="Emprestar o livro">Emprestar</abbr></button>
              </form>
              
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</body>

</html>