<?php
    include '../../controladores/autenticacao_usuario.php';
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
    endif;
    include '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Movimentação </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
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
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>