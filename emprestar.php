<?php

/** @var $pdo \PDO */
require_once "database.php";


$id_aluno = $_GET['id_aluno'] ?? null;

//Puxa os Parâmetros
$dados = rawurldecode($_GET['dados'] ?? null);

$metadados = explode('&', $dados);

$id = $metadados[0];

$QTDE = $metadados[1];

$QTD = $metadados[2];

$QTDEFinal = $QTDE + 1;

$origem = $metadados[3];

$Parametro = $metadados[4] . $metadados[5] . $metadados[6] . $metadados[7];

$location = "Location:" . $origem . $Parametros . "#a" . $id;

// checar se id foi "chamado"
if (!$id_aluno || !$dados) {
    header("Location: livros-acervo.php");
    exit;
}

/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare('SELECT * FROM livros WHERE id = :id');
$statement->bindValue(":id", $id);
$statement->execute();

$livro = $statement->fetch(PDO::FETCH_ASSOC);

if ($QTD >= $QTDEFinal) {

    $statement2 = $pdo->prepare('UPDATE livros SET Situacao = :situacao , Emprestados = :qtdef WHERE id = :id ');
    $statement2->bindValue(":id", $id);
    $statement2->bindValue(":situacao", "Emprestado");
    $statement2->bindValue(":qtdef", $QTDEFinal);

    $statement2->execute();
}

$statement3 = $pdo->prepare('SELECT * FROM alunos WHERE id_aluno = :id_aluno');
$statement3->bindValue(":id_aluno", $id_aluno);
$statement3->execute();

$aluno = $statement3->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome_aluno = $_POST['nome_aluno'];
    $turma_aluno = $_POST['turma_aluno'];
    $telefone_aluno = $_POST['telefone_aluno'];

    $statement = $pdo->prepare("UPDATE alunos SET nome_aluno = :nome_aluno, turma_aluno = :turma_aluno, telefone_aluno = :telefone_aluno WHERE id_aluno = :id_aluno");

    $statement->bindValue(':nome_aluno', $nome_aluno);
    $statement->bindValue(':turma_aluno', $turma_aluno);
    $statement->bindValue(':telefone_aluno', $telefone_aluno);
    $statement->bindValue(':id_aluno', $id_aluno);
    $statement->execute();

    redirect($location);
}

redirect($location);

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
            <input type="text" name="nome_aluno" disabled value="<?php echo $nome_aluno; ?>" class="form-control" placeholder="Autor" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Turma</span>
            <input type="text" name="turma_aluno" value="<?php echo $turma_aluno; ?>" class="form-control" placeholder="Título" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Telefone</span>
            <input type="text" name="telefone_aluno" value="<?php echo $telefone_aluno; ?>" class="form-control" placeholder="telefone_aluno" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
        <button type="submit" class="btn btn-success">Editar</button>
    </form>
</body>

</html>