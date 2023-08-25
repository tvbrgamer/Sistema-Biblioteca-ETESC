<?php

/** @var $pdo \PDO */
require_once "database.php";


$id_aluno = $_GET['id_aluno'] ?? null;

//Puxa os Parâmetros
$dados = rawurldecode($_GET['dados'] ?? null);

$metadados = explode('&', $dados);

$id_livro = $metadados[0];

$id_livronum = explode('=', $id_livro);

$QTDE = $metadados[1];

$QTDEnum = explode('=', $QTDE);

$QTD = $metadados[2];

$QTDnum = explode('=', $QTD);

$QTDEFinal = $QTDEnum[1] + 1;

$origem = explode('=', $metadados[3]);

$Para = explode('=', $metadados[4]);

if(!$Para[2]){
    $Para[1] = "?";
    $Para[2] = "";
}else{
    $Para[1] = $Para[1] . "=";
    $Para[2] = $Para[2] . "&";
}

$Parametros = $Para['1'] . $Para['2'] . $metadados[5] . '&' . $metadados[6]. '&' . $metadados[7];

$location = "Location:" . $origem[1] . $Parametros . "&tipo=empresta";

// checar se id foi "chamado"
if (!$id_aluno || !$dados) {
    header("Location: livros-acervo.php");
    exit;
}

/** @var $pdo \PDO */
require_once "database.php";

$statement = $pdo->prepare('SELECT * FROM livros WHERE id = :id');
$statement->bindValue(":id", $id_livronum[1]);
$statement->execute();

$livro = $statement->fetch(PDO::FETCH_ASSOC);

if ($QTDnum[1] >= $QTDEFinal) {

    $statement2 = $pdo->prepare('UPDATE livros SET Situacao = :situacao , Emprestados = :qtdef WHERE id = :id ');
    $statement2->bindValue(":id", $id_livronum[1]);
    $statement2->bindValue(":situacao", "Emprestado");
    $statement2->bindValue(":qtdef", $QTDEFinal);

    $statement2->execute();

    $statement3 = $pdo->prepare('SELECT * FROM alunos WHERE id_aluno = :id_aluno');
    $statement3->bindValue(":id_aluno", $id_aluno);
    $statement3->execute();
    
    $aluno = $statement3->fetch(PDO::FETCH_ASSOC);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $data_emprestimo = $_POST['data_emprestimo'];
        $data_devolucao = $_POST['data_devolucao'];
        
        $statement3 = $pdo->prepare("UPDATE alunos SET id_livro = :id_livro, data_emprestimo = :data_emprestimo, data_devolucao = :data_devolucao WHERE id_aluno = :id_aluno");
        
        $statement3->bindValue(':id_aluno', $id_aluno);
        $statement3->bindValue(':id_livro', $id_livronum[1]);
        $statement3->bindValue(':data_emprestimo', $data_emprestimo);
        $statement3->bindValue(':data_devolucao', $data_devolucao);
        $statement3->execute();
        
        header($location);
        die();
    }
}else{
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
            <span class="input-group-text" id="basic-addon1">Nome do aluno</span>
            <input type="text" name="nome_aluno" disabled value="<?php echo $aluno['nome_aluno']; ?>" class="form-control" placeholder="Nome do aluno" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Nome do livro</span>
            <input type="text" name="nome_livro" disabled class="form-control"  value="<?php echo $livro['titulo']; ?>" placeholder="Nome do livro" aria-label="Username" aria-describedby="basic-addon1">
        </div>


        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Data de empréstimo</span>
            <input type="date" name="data_emprestimo" va class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <div class="input-group mb-3">
            <span class="input-group-text" id="basic-addon1">Data de devolução</span>
            <input type="date" name="data_devolucao" class="form-control" aria-label="Username" aria-describedby="basic-addon1">
        </div>

        <button type="reset" class="btn btn-outline-secondary">Limpar campos</button>
        <button type="submit" class="btn btn-success">Emprestar</button>

    </form>
</body>

</html>