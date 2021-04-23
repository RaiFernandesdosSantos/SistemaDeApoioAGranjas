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
    $id_galpao = $dg['id'];
    $sql = "SELECT * FROM baia WHERE id = '$id_galpao'";
    $r2 = mysqli_query($conexao, $sql);
    $db = mysqli_fetch_array($r2);
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);
        $sql = "UPDATE galpao SET identificacao = '$identificacao', funcao = '$funcao' WHERE identificacao = '$nome'";
        $salvar = mysqli_query($conexao, $sql);
    elseif(isset($_POST['btn-delet'])):
        $deletar = "DELETE FROM galpao WHERE identificacao = '$nome'";
        $salvar = mysqli_query($conexao, $deletar);
        $deletar_baia = "DELETE FROM baia WHERE id_galpao = '$id_galpao'";
        $salvar = mysqli_query($conexao, $deletar_baia);
        header('Location: lista_baia_galpao.php');
    endif;
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
                    <table class="table">
                        <tbody>
                            <tr>
                                
                                <label for="iden"> Identificação: </label>
                                <input type="text" name="i" id="iden" class="form-control" value="<?php echo $dg['identificacao']; ?>">
                            </tr>
                            <tr>
                                <th scope="row"> Quantidade de Baias: </th>
                                <td> <?php echo $dg['qtde_baias']; ?> </td>
                            </tr>
                            <tr>
                                <th scope="row"> Total Atual de Porcos </th>
                                <td> <?php echo $dg['total_porcos']; ?> </td>
                            </tr>
                            <tr>
                                <label for="funcao"> Função do Galpão: </label>
                                <select class="form-control" name="f" id="funcao">
                                    <option value="<?php echo $dg['funcao']; ?>"> <?php echo $dg['funcao']; ?> </option>
                                    <option value="Maternidade"> Maternidade </option>
                                    <option value="Creche"> Creche </option>
                                    <option value="Terminacao"> Terminação </option>
                                    <option value="Quarentena"> Quarentena </option>
                                </select>
                            </tr>
                        </tbody>
                    </table>
                    <button class="btn btn-outline-success btn-sm" type="submit" name="btn-submit"> Mudar Dados do Galpão </button>
                    <button class="btn btn-outline-danger btn-sm" type="submit" name="btn-delet"> Deletar Galpão </button>
                    <a href="movimentar.php" class="btn btn-outline-primary"> Movimentar animais </a>
                </form>
            </div>
        </div>
    </body>
</html>