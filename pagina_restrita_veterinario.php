<?php
    include_once("conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    mysqli_close($conexao);
    if(!isset($_SESSION['logado'])):
        header('Loacation: index.php');
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
    <body class="text-center gradiente">
        <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="pagina_restrita_gerente.php"> SWMES </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="galpoes.php"> Galpões </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sistema_engorda.php"> Sistema de engorda </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="estoque.php"> Estoque </a>
                    </li>
                </ul>
                <div class="my-2 my-lg-0">
                    <p> Olá <a href="perfil.php"> <?php echo $dados['nome']; ?></a>, <a href="logout.php"> Sair </a></p>
                </div>
            </div>
        </nav>
    </body>
</html>