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
    $statement = $pdo->prepare("SELECT * FROM livros WHERE  Emprestados > 0 AND Autor LIKE :autor OR titulo LIKE :titulo ORDER BY ID DESC");
  } else {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados > 0 AND Autor LIKE :autor OR titulo LIKE :titulo");
  }

  $statement->bindValue(":autor", "%$search%");
  $statement->bindValue(":titulo", "%$search%");
} else {
  if ($ordem == "DESC") {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados > 0 ORDER BY ID DESC LIMIT $start , $limit ");
  } else {
    $statement = $pdo->prepare("SELECT * FROM livros WHERE Emprestados > 0  LIMIT $start , $limit ");
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
  <title>Acervo-emprestados</title>
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
          <th scope="col">Ação</th>
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

            <td style="white-space: nowrap;">
              <!--<a href="editar-livro.php?id=<?php echo $livro['id'] ?>" class="btn btn-sm btn-outline-primary">Editar</a> -->

              <form id="devolve<?php echo $livro['id'] ?>" action="entregar-livro.php" method="post" style="display: inline-block">
                <input type="hidden" name="id" value="<?php echo $livro['id'] ?>">
                <input type="hidden" name="QTDEmprestado" value="<?php echo $livro['Emprestados'] ?>">
                <input type="hidden" name="QTD" value=<?php echo $livro['Quantidade'] ?>>
                <input type="hidden" name="Parametro" value="<?php $parametro  ?>">
                <input type="hidden" name="origem" value=<?php echo $origem ?>>
                <button type="button" onclick="Devolver(<?php echo $livro['id'] ?>)" class="btn btn-sm btn-danger"><abbr title="Devolver 1 livro">Devolver</abbr></button>
              </form>

              <form id="empresta<?php echo $livro['id'] ?>" action="emprestar-livro.php" method="post" style="display: inline-block">
                <input type="hidden" name="id" value="<?php echo $livro['id'] ?>">
                <input type="hidden" name="QTDEmprestado" value="<?php echo $livro['Emprestados'] ?>">
                <input type="hidden" name="QTD" value=<?php echo $livro['Quantidade'] ?>>
                <input type="hidden" name="origem" value=<?php echo $origem ?>>
                <input type="hidden" name="Parametro" value="<?php echo $parametro ?>">

                <button type="button" onclick="Valida(<?php echo $livro['Quantidade'] ?> , <?php echo $livro['Emprestados'] ?>,<?php echo $livro['id'] ?> )" name="emprestar" class="btn btn-sm btn-secondary"><abbr title="Emprestar 1 livro">Emprestar</abbr></button>
              </form>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </section>
</body>

</html>

<script>
  function Devolver(id) {
    swal({
        title: "Tem certeza?",
        icon: "warning",
        buttons: true,
      })
      .then((willValide) => {
        if (willValide) {
          swal("O livro foi devolvido", {
            icon: "success",
          });
          setTimeout(() => {
            document.getElementById('devolve' + id).submit();
          }, 1000);
        }else {
          swal("Livro não devolvido");
        }
      });
  }

  function Valida(QTD, QTDE, ID) {
    swal({
        title: "Tem certeza?",
        icon: "warning",
        buttons: true,
      })
      .then((willValide) => {
        if (willValide) {
          if (QTD >= (QTDE + 1)) {
            swal("O livro foi emprestado", {
              icon: "success",
            });
            setTimeout(() => {
              document.getElementById('empresta' + ID).submit();
            }, 1000);
          } else {
            swal("Quantidade de livros insuficientes para emprestar");
          }
        }else {
          swal("Livro emprestado");
        }
      });
  }

  // Seleciona o elemento select pelo seu ID
  const select = document.querySelector('#select');
  const ordem = document.querySelector('#ordem');

  // Adiciona um listener para o evento 'change' do elemento select
  ordem.addEventListener('change', (event) => {
    // Obtém o valor selecionado
    const ordemValue = event.target.value;

    // Obtém o valor atual de 'ordem' da URL
    const url = new URL(window.location.href);
    const currentOrdem = url.searchParams.get('ordem') || "ASC";

    // Atualiza a URL com os novos valores de 'ordem'
    url.searchParams.set('ordem', ordemValue);

    window.history.pushState({}, '', url);
    window.location.reload(true);
  })

  // Adiciona um listener para o evento 'change' do elemento select
  select.addEventListener('change', (event) => {
    // Obtém o valor selecionado
    const selectedValue = parseInt(event.target.value);

    // Obtém o valor atual de 'start' e 'limit' da URL
    const url = new URL(window.location.href);
    const currentLimit = parseInt(url.searchParams.get('limit') || 25);

    // Atualiza a URL com os novos valores de 'limit'
    url.searchParams.set('limit', selectedValue);

    window.history.pushState({}, '', url);
    window.location.reload(true);
  });
</script>