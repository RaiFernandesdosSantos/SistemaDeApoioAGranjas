<?php
    include '../../controladores/autenticacao_usuario.php';
    $nome = $_SESSION['db'];
    $sql = "SELECT * FROM baia WHERE identificacao = '$nome'";
    $r1 = mysqli_query($conexao, $sql);
    $db = mysqli_fetch_array($r1);
    $id_baia = $db['id'];
    $id_galpao = $db['id_galpao'];
    $sql = "SELECT * FROM galpao WHERE id = '$id_galpao'";
    $r2 = mysqli_query($conexao, $sql);
    $dg = mysqli_fetch_array($r2);
    $sql = "SELECT * FROM historico_baia WHERE id_baia = '$id_baia' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE id_baia = '$id_baia')";
    $r3 = mysqli_query($conexao, $sql);
    $hb = mysqli_fetch_array($r3);
    $menos_baia = $dg['qtde_baias'] - 1;
    $menos_porcos = $dg['total_porcos'] - $hb['qtde_porcos'];
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $qtde_porcos = mysqli_escape_string($conexao, $_POST['qp']);
        $capacidade = mysqli_escape_string($conexao, $_POST['ctp']);
        $media_peso = mysqli_escape_string($conexao, $_POST['mp']);
        $sql = "UPDATE baia SET identificacao = '$identificacao', capacidade_total_porcos = '$capacidade' WHERE identificacao = '$nome'";
        $salvar = mysqli_query($conexao, $sql);
        $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) VALUES ('$id_baia', '$id', now(), '$qtde_porcos', '$media_peso')";
        $salvar = mysqli_query($conexao, $sql);
        $mais_porcos = $dg['total_porcos'] + $hb['qtde_porcos'];
        $sql = "UPDATE galpao SET total_porcos = '$mais_porcos' WHERE id = '$id_galpao'";
        $salvar = mysqli_query($conexao, $sql);
    elseif(isset($_POST['btn-delet'])):
        $deletar = "DELETE FROM baia WHERE identificacao = '$nome'";
        $salvar = mysqli_query($conexao, $deletar);
        $deletar = "DELETE FROM historico_baia WHERE id = '$id_baia'";
        $salvar = mysqli_query($conexao, $deletar);
        $atualiza = "UPDATE galpao SET qtde_baias = '$menos_baia', total_porcos = '$menos_porcos' WHERE id = '$id_galpao'";
        $salvar = mysqli_query($conexao, $atualiza);
        header('Location: lista_baia_galpao.php');
    endif;
    require_once '../../controladores/verificar_galpao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../../css/estilo.css" rel="stylesheet" media="screen">
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
                            <a class="nav-link" href="#"> Sistema de engorda </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../cadastros/registro.php"> Cadastro de Funcionarios </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo $pagina; ?>"> Galpões </a>
                        </li>
                    </ul>
                    <div class="my-2 my-lg-0">
                        <p> Olá <a href="#"> <?php echo $dados['nome']; ?></a>, <a href="../../controladores/logout.php"> Sair </a></p>
                    </div>
                </div>
            </nav>
            <div class=" offset-md-2 offset-lg-2 col-md-8 col-lg-8 bg-light">
                <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h1 class="h3 mb-3 font-weight-normal"> <?php echo $db['identificacao']; ?> </h1>
                    <label for="iden"> Identificação: </label>
                    <input type="text" name="i" id="iden" class="form-control" value="<?php echo $db['identificacao']; ?>">
                    <label for="baias"> Quantidade de Porcos: </label>
                    <input type="text" name="qp" id="porcos" class="form-control" value="<?php echo $hb['qtde_porcos']; ?>">
                    <label for="baias"> Capacidade Total de Porcos: </label>
                    <input type="text" name="ctp" id="baias" class="form-control" value="<?php echo $db['capacidade_total_porcos']; ?>">
                    <label for="baias"> Media de Peso da Baia: </label>
                    <input type="text" name="mp" id="baias" class="form-control" value="<?php echo $hb['media_peso']; ?>">
                    <button class="btn btn-outline-success" type="submit" name="btn-submit"> Mudar Dados da Baia </button>
                    <button class="btn btn-outline-danger" type="submit" name="btn-delet"> Deletar Baia </button>
                    <a href="../movimentacao/movimentar.php" class="btn btn-outline-primary"> Movimentar animais </a>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>