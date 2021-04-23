<?php
    include_once("conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    if(!isset($_SESSION['logado'])):
        header('Location: index.php');
    endif;
    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['nome']);
        $fabricante = mysqli_escape_string($conexao, $_POST['fabricante']);
        $unidade = mysqli_escape_string($conexao, $_POST['unidade']);
        $sql = "INSERT INTO item(nome, fabricante, unidade, qtde) VALUES ('$nome', '$fabricante', '$unidade', 0)";
        $salvar = mysqli_query($conexao, $sql);
        mysqli_close($conexao);
        unset($conexao);
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="gradiente">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="navbar-brand" href="pagina_restrita_gerente.php"> SWMES </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sistema_engorda.php"> Sistema de engorda </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php"> Cadastro de Funcionarios </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="lista_baia_galpao.php"> Galpões </a>
                        </li>
                    </ul>
                    <div class="my-2 my-lg-0">
                        <p> Olá <a href="perfil.php"> <?php echo $dados['nome']; ?></a>, <a href="logout.php"> Sair </a></p>
                    </div>
                </div>
            </nav>
            <div class=" offset-md-2 offset-lg-2 col-md-8 col-lg-8 bg-light">
                <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Produtos </h1>
                    <label for="n" class="sr-only"> Nome </label>
                    <input type="text" name="nome" id="n" class="form-control" placeholder="Nome" required>
                    <label for="f" class="sr-only"> Fabricante </label>
                    <input type="text" name="fabricante" id="f" class="form-control" placeholder="Fabricante" required>
                    <label for="u"> Informe a unidade do produto: </label>
                    <select class="form-control" name="unidade" id="u">
                        <option value=""> Selecione </option>
                        <option value="Kg"> Quilogramas </option>
                        <option value="Ml"> Mililitros </option>
                        <option value="G"> Gramas </option>
                        <option value="L"> Litros </option>
                    </select>
                    <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar-se </button>
                </form>
            </div>
        </div>
    </body>
</html>