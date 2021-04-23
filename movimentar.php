<?php
    include_once("conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    if(!isset($_SESSION['logado'])):
        header('Loacation: index.php');
    endif;
    if(isset($_POST['btn-submit'])):
        $idbo = mysqli_escape_string($conexao, $_POST['b']);
        $idbd = mysqli_escape_string($conexao, $_POST['g']);
        $qtde = mysqli_escape_string($conexao, $_POST['q']);
        $motivo = mysqli_escape_string($conexao, $_POST['m']);
        $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbo' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE id_baia = '$idbo')";
        $rs = mysqli_query($conexao, $sql);
        $hbo = mysqli_fetch_array($rs);
        $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbd' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE id_baia = '$idbo')";
        $rs = mysqli_query($conexao, $sql);
        $hbd = mysqli_fetch_array($rs);
        $menos = $hbo['qtde_porcos'] - $qtde;
        $mais = $hbd['qtde_porcos'] + $qtde;
        $mpo = $hbo['media_peso'];
        $mpd = $hbd['media_peso'];
        $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) VALUES ('$idbo', '$id', now(), '$menos', '$mpo', '$motivo')";
        $salvar = mysqli_query($conexao, $sql);
        $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) VALUES ('$idbd', '$id', now(), '$mais', '$mpd', '$motivo')";
        $salvar = mysqli_query($conexao, $sql);
        header('Location: movimentar.php');
        mysqli_close($conexao);
        unset($conexao);
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Movimentação </title>
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
                    <label for="baia"> Mover animais de: </label>
                    <select class="form-control" name="b" id="baia">
                        <option value=""> Selecione uma opção </option>
                        <?php 
                            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                            while($gp = mysqli_fetch_array($galpoes))
                            {
                                $gpid = $gp['id'];
                        ?>
                        <label for="b<?php echo $gp['id']; ?>"><?php echo $gp['identificacao']; ?></label>
                        <?php 
                            $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                            while($ba = mysqli_fetch_array($baias))
                            {
                        ?>
                        <option value="<?php echo $ba['id']; ?>" id="b<?php echo $gp['id']; ?>"><?php echo $ba['identificacao'] ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                    <label for="galpoes"> Mover animais para: </label>
                    <select class="form-control" name="g" id="galpoes">
                        <option value=""> Selecione uma opção </option>
                        <?php 
                            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                            while($gp = mysqli_fetch_array($galpoes))
                            {
                                $gpid = $gp['id'];
                        ?>
                        <label for="g<?php echo $gp['id']; ?>"><?php echo $gp['identificacao']; ?></label>
                        <?php 
                            $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                            while($ba = mysqli_fetch_array($baias))
                            {
                        ?>
                        <option value="<?php echo $ba['id']; ?>" id="g<?php echo $gp['id']; ?>"><?php echo $ba['identificacao'] ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                    <label for="qtde"> Quantidade de animais a ser movimentada: </label>
                    <input type="text" name="q" id="qtde" class="form-control" placeholder="Quantidade de animais movimentada" required>
                    <label for="motivo"> Motivo da movimentação: </label>
                    <input type="text" name="m" id="motivo" class="form-control" placeholder="Motivo da Movimentação" required>
                    <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Movimentar animais </button>
                </form>
            </div>
        </div>
    </body>
</html>