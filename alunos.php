<?php

/** @var $pdo \PDO */
require_once "database.php";

$dados  = $_GET['dados'] ?? 'nada';
$dadosurl = "dados=" . rawurlencode($dados);

$tipo = $_GET['tipo'] ?? '';

$search = $_GET['pesquisa'] ?? '';
$limit  = $_GET['limit']    ?? 25;
$start  = $_GET['start']    ?? 0;
$ordem  = $_GET['ordem']    ?? "ASC";
$origem = "alunos.php";
$startelimit = $start + $limit;

$id_livro = $_POST['id_livro'] ?? null;

$parametro = "?" . "pesquisa=" . $search . "&" . "limit=" . $limit . "&" . "start=" . $start . "&" . "ordem=" . $ordem;

if ($id_livro) {
    $statement = $pdo->prepare("SELECT *,DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
    DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado from alunos where id_livro = :id_livro LIMIT :start , :limit");

    $statement->bindValue(":id_livro", $id_livro, PDO::PARAM_INT);
} else {

    if ($search) {

        if ($ordem == "DEVO") {
            $statement = $pdo->prepare("SELECT *, DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
                                              DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado
                                              FROM alunos WHERE nome_aluno LIKE :aluno OR turma_aluno LIKE :turma ORDER BY data_devolucao DESC, id_aluno DESC LIMIT :start , :limit");
        } else if ($ordem == "DESC") {
            $statement = $pdo->prepare("SELECT *, DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
                                              DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado
                                              FROM alunos WHERE nome_aluno LIKE :aluno OR turma_aluno LIKE :turma ORDER BY id_aluno DESC LIMIT :start , :limit");
        } else {
            $statement = $pdo->prepare("SELECT *, DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
                                              DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado
                                              FROM alunos WHERE nome_aluno LIKE :aluno OR turma_aluno LIKE :turma LIMIT :start , :limit");
        }

        $statement->bindValue(":aluno", "%$search%");
        $statement->bindValue(":turma", "%$search%");
    } else {
        if ($ordem == "DEVO") {
            $statement = $pdo->prepare("SELECT *, DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
                                              DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado
                                              FROM alunos ORDER BY data_devolucao DESC, id_aluno DESC LIMIT :start , :limit");
        } else if ($ordem == "DESC") {
            $statement = $pdo->prepare("SELECT *, DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
                                              DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado
                                              FROM alunos ORDER BY id_aluno DESC LIMIT :start , :limit");
        } else {
            $statement = $pdo->prepare("SELECT *, DATE_FORMAT(data_devolucao, '%d/%m/%Y') as dt_dv_formatado,
                                              DATE_FORMAT(data_emprestimo, '%d/%m/%Y') as dt_de_formatado
                                              FROM alunos LIMIT :start , :limit");
        }
    }
}

$statement->bindValue(":start", $start, PDO::PARAM_INT);
$statement->bindValue(":limit", $limit, PDO::PARAM_INT);
$statement->execute();

$alunos = $statement->fetchAll(PDO::FETCH_ASSOC);

$statement2 = $pdo->prepare("SELECT id, titulo, Autor FROM livros");
$statement2->execute();
$livros = $statement2->fetchAll(PDO::FETCH_ASSOC);

$livrosAssociativos = array(); // Array associativo para armazenar informações dos livros

foreach ($livros as $livro) {
    $livrosAssociativos[$livro['id']] = $livro;
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Alunos</title>
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">

    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/acervo.css" />

    <link href="css/bootstrap.css" rel="stylesheet">

    <script defer type="text/javascript" src="js/acervo.js"></script>
    <script defer type="text/javascript" src="js/Notify.js"></script>
    <script type="text/javascript" src="js/sweetalert.js"></script>
</head>

<body <?php
        if ($tipo != null) {
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
                <input type="search" class="form-control" name="pesquisa" value="<?php echo $search; ?>" placeholder="Pesquisar Aluno/Turma" autocomplete="off">
                <div class="query__btns">
                    <button class="btn btn-success shadow" type="submit">Pesquisar Alunos</button>

                    <a href="alunos.php" class="btn btn-outline-secondary shadow">Limpar Campos</a>

                    <a href='cadastro-alunos.php<?php if ($dados != "nada") {
                                                    echo "?" . $dadosurl;
                                                } ?>' class="btn btn-primary shadow">Cadastrar Aluno</a>

                </div>

                <section class="selecao-section">

                    <form class="paginacao" method="GET">

                        <div id="LPP" style="width: 200px;">

                            <h6>Alunos por página:</h6>
                            <select id="select" name="limit">
                                <option value="25" <?php if ($limit == 25) echo "selected"; ?>>25</option>
                                <option value="50" <?php if ($limit == 50) echo "selected"; ?>>50</option>
                                <option value="100" <?php if ($limit == 100) echo "selected"; ?>>100</option>
                                <option value="250" <?php if ($limit == 250) echo "selected"; ?>>250</option>
                                <option value="500" <?php if ($limit == 500) echo "selected"; ?>>500</option>
                            </select>
                        </div>
                        <div id="Ordem" style="width:200px;">

                            <h6> Ordem dos Alunos:</h6>
                            <select id="ordem" name="ordem">
                                <option value="ASC" <?php if ($ordem == "ASC") echo "selected"; ?>>Crescente</option>
                                <option value="DESC" <?php if ($ordem == "DESC") echo "selected"; ?>>Decrescente</option>
                                <option value="DEVO" <?php if ($ordem == "DEVO") echo "selected"; ?>>Devolução</option>
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
                    <th scope="col">Nome</th>
                    <th scope="col">Turma</th>
                    <th scope="col">Telefone</th>
                    <th scope="col">Nome do livro</th>
                    <th scope="col">Autor livro</th>
                    <th scope="col">Data de Empréstimo</th>
                    <th scope="col">Data de devolução</th>
                    <th scope="col">Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($alunos as $a => $aluno) : ?>
                    <tr>
                        <td><b><a id="a<?php echo $aluno['id_aluno'] ?>"><?php echo $aluno['id_aluno'] ?></a></b></td>
                        <td><?php echo $aluno['nome_aluno'] ?></td>
                        <td><?php echo $aluno['turma_aluno'] ?></td>
                        <td><?php echo $aluno['telefone_aluno'] ?></td>
                        <td><?php echo !empty($livrosAssociativos[$aluno['id_livro']]) ? $livrosAssociativos[$aluno['id_livro']]['titulo'] : '-' ?></td>
                        <td><?php echo !empty($livrosAssociativos[$aluno['id_livro']]) ? $livrosAssociativos[$aluno['id_livro']]['Autor'] : '-' ?></td>
                        <td><?php if ($aluno['dt_de_formatado'] != "00/00/0000") {
                                echo $aluno['dt_de_formatado'];
                            } else {
                                echo "-";
                            } ?></td>
                        <td><?php if ($aluno['dt_dv_formatado'] != "00/00/0000") {
                                echo $aluno['dt_dv_formatado'];
                            } else {
                                echo "-";
                            } ?></td>

                        <td style="white-space: nowrap;">
                            <!-- <a href="editar-livro.php?id=<?php echo "apagar_teste" ?>" class="btn btn-sm btn-outline-primary">Editar</a> -->

                            <?php if ($dados != "nada") {
                                echo '
                                    <form id="empresta' . $aluno['id_aluno'] . '" action="emprestar.php" method="get" style="display: inline-block">
                                        <input type="hidden" name="id_aluno" value="' . $aluno['id_aluno'] . '">
                                        <input type="hidden" name="dados" value="' . $dados . '">
                                        <button type="button" onclick="Empresta(' . $aluno['id_aluno'] . ', ' . $aluno['id_livro'] . ')" class="btn btn-sm btn-secondary"><abbr title="Seleciona o aluno">Selecionar</abbr></button>
                                    </form>';
                            } ?>


                            <form id="devolve<?php echo $aluno['id_aluno'] ?>" action="devolver.php" method="get" style="display: inline-block">
                                <input type="hidden" name="id_aluno" value="<?php echo $aluno['id_aluno'] ?>">
                                <input type="hidden" name="id_livro" value="<?php echo $aluno['id_livro'] ?>">
                                <?php if ($dados != 'nada') {
                                    echo "<input type='hidden' name='dados' value='" . $dados . "'>";
                                } ?>
                                <button type="button" onclick="Devolve(<?php echo $aluno['id_aluno'] ?>);" class="btn btn-sm btn-success shadow"><abbr title="Devolve o livro emprestado">Devolver</abbr></button>
                            </form>

                            <form id="edita<?php echo $aluno['id_aluno'] ?>" action="editar-aluno.php" method="get" style="display: inline-block">
                                <input type="hidden" name="id_aluno" value="<?php echo $aluno['id_aluno'] ?>">
                                <input type="hidden" name="origem" value=<?php echo $origem ?>>
                                <input type="hidden" name="Parametro" value="<?php echo $parametro ?>">
                                <?php if ($dados != 'nada') {
                                    echo "<input type='hidden' name='dados' value='" . $dados . "'>";
                                } ?>
                                <button type="button" onclick="editaAluno(<?php echo $aluno['id_aluno'] ?>);"" class=" btn btn-sm btn-outline-primary"><abbr title="Edita os dados do aluno">Editar</abbr></button>
                            </form>

                            <form id="excluir<?php echo $aluno['id_aluno'] ?>" action="excluir-aluno.php" method="get" style="display: inline-block">
                                <input type="hidden" name="id_aluno" value="<?php echo $aluno['id_aluno'] ?>">
                                <button type="button" onclick="validaDelete(<?php echo $aluno['id_aluno'] ?> , <?php echo $aluno['id_livro'] ?>)" class="btn btn-sm btn-danger"><abbr title="Excluir cadastro">Excluir</abbr></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>

</html>