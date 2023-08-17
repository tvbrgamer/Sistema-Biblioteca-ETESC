<?php

/** @var $pdo \PDO */
require_once "database.php";


$id_aluno = $_GET['id_aluno'] ?? null;

//Puxa os Parâmetros
$Parametros = $_GET['Parametro'] ?? null;

$location = "alunos.php" . $Parametros . "#a" . $id_aluno;

if (!$id_aluno) {
    header("Location: livros-acervo.php");
    exit;
}

$statement = $pdo->prepare('SELECT * FROM alunos WHERE id_aluno = :id_aluno');
$statement->bindValue(":id_aluno", $id_aluno);
$statement->execute();

$livro = $statement->fetch(PDO::FETCH_ASSOC);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_livro = $_POST['id_livro'];
    $classificacao = $_POST['classificacao'];
    $quantidade = $_POST['quantidade'];

    $statement = $pdo->prepare("UPDATE alunos SET id_livro = :id_livro, data_emprestimo = :data_emprestimo, data_devolucao = :data_devolucao WHERE id = :id");

    $statement->bindValue(':id_livro', $id_livro);
    $statement->bindValue(':data_emprestimo', $data_emprestimo);
    $statement->bindValue(':data_devolucao', $data_devolucao);
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
        </nav>
    </header>

    <form class="cadastro-section" method="POST">
        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Id do Livro</span>
            <input type="text" name="autor" value="<?php echo $id_livro; ?>" class="form-control" placeholder="Autor" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Data de empréstimo</span>
            <input type="text" name="titulo" value="<?php echo $data_emprestimo; ?>" class="form-control" placeholder="Título" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Data de devolução</span>
            <input type="text" name="assunto" value="<?php echo $data_devolucao; ?>" class="form-control" placeholder="Assunto" aria-label="Username" aria-describedby="basic-addon1">
        </div>


        <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
        <button type="submit" class="btn btn-success">Editar</button>
    </form>
</body>

</html>