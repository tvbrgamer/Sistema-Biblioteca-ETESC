<?php

/** @var $pdo \PDO */
require_once "database.php";


$id_aluno = $_GET['id_aluno'] ?? null;

//Puxa os Parâmetros
$Parametros = $_GET['Parametro'] ?? null;

$dados = rawurlencode($_GET['dados'] ?? "nada");

$location = "Location:alunos.php" . $Parametros . "&dados=" . $dados . "#a" . $id_aluno;

if (!$id_aluno) {
    header("Location: alunos.php");
    exit;
}

$statement = $pdo->prepare('SELECT * FROM alunos WHERE id_aluno = :id_aluno');
$statement->bindValue(":id_aluno", $id_aluno);
$statement->execute();

$aluno = $statement->fetch(PDO::FETCH_ASSOC);


$nome_aluno = $aluno['nome_aluno'];
$turma_aluno = $aluno['turma_aluno'];
$telefone_aluno = $aluno['telefone_aluno'];
echo $aluno['nome_aluno'];


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
    <script src="js/Cleave.js"></script>
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
            <input type="text" name="nome_aluno" value="<?php echo $nome_aluno; ?>" class="form-control" placeholder="Autor" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Turma</span>
            <input type="text" id="turma" name="turma_aluno" value="<?php echo $turma_aluno; ?>" class="form-control" placeholder="Título" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Telefone</span>
            <input type="text" id="tel" name="telefone_aluno" value="<?php echo $telefone_aluno; ?>" class="form-control" placeholder="telefone_aluno" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
        <button type="submit" class="btn btn-success">Editar</button>
    </form>
</body>

</html>

<Script>
document.addEventListener("DOMContentLoaded", () => {
  new Cleave("#turma", {
    delimiters: ["/"],
    blocks: [4, 2],
    numericOnly: true,
  });
});

document.addEventListener("DOMContentLoaded", () => {
  new Cleave("#tel", {
    delimiters: ["(", ") ", " ", "-"],
    blocks: [0, 2, 1, 4, 4],
    numericOnly: true,
  });
});
</Script>