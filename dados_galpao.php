<?php
    include_once("conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $nome = $_SESSION['dg'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    if(!isset($_SESSION['logado'])):
        header('Loacation: index.php');
    endif;
    $sql2 = "SELECT * FROM galpao WHERE identificacao = '$nome'";
    $r1 = mysqli_query($conexao, $sql2);
    $dg = mysqli_fetch_array($r1);
    mysqli_close($conexao);
    unset($conexao);
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
                            <a class="nav-link" href="sistema_financeiro.php"> Sistema financeiro </a>
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
                <table>
                    <tr>
                        <th> Identificação: </th>
                        <td> <?php echo $dg['identificacao']; ?> </td>
                    </tr>
                    <tr>
                        <th> Quantidade de Baias: </th>
                        <td> <?php echo $dg['qtde_baias']; ?> </td>
                    </tr>
                    <tr>
                        <th> Total de Porcos: </th>
                        <td> <?php echo $dg['total_porcos']; ?> </td>
                    </tr>
                    <tr>
                        <th> Função: </th>
                        <td> <?php echo $dg['funcao']; ?> </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>