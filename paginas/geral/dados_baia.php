<?php
    include '../../controladores/autenticacao_usuario.php';
    $idb = $_SESSION['db'];
    $sql = "SELECT * FROM baia WHERE id = '$idb'";
    $rs = mysqli_query($conexao, $sql);
    $db = mysqli_fetch_array($rs);
    $id_galpao = $db['id_galpao'];
    $sql = "SELECT * FROM galpao WHERE id = '$id_galpao'";
    $rs = mysqli_query($conexao, $sql);
    $dg = mysqli_fetch_array($rs);
    $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idb' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE id_baia = '$idb')";
    $rs = mysqli_query($conexao, $sql);
    $hb = mysqli_fetch_array($rs);
    $menos_baia = $dg['qtde_baias'] - 1;
    $menos_porcos = $dg['total_porcos'] - $hb['qtde_porcos'];
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $qtde_porcos = mysqli_escape_string($conexao, $_POST['qp']);
        $capacidade = mysqli_escape_string($conexao, $_POST['ctp']);
        $media_peso = mysqli_escape_string($conexao, $_POST['mp']);
        $sql = "UPDATE baia SET identificacao = '$identificacao', capacidade_total_porcos = '$capacidade' WHERE id = '$idb'";
        $salvar = mysqli_query($conexao, $sql);
        $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) VALUES ('$idb', '$id', now(), '$qtde_porcos', '$media_peso')";
        $salvar = mysqli_query($conexao, $sql);
        $mais_porcos = $dg['total_porcos'] + $hb['qtde_porcos'];
        $sql = "UPDATE galpao SET total_porcos = '$mais_porcos' WHERE id = '$id_galpao'";
        $salvar = mysqli_query($conexao, $sql);
    elseif(isset($_POST['btn-delet'])):
        $deletar = "DELETE FROM baia WHERE id = '$idb'";
        $salvar = mysqli_query($conexao, $deletar);
        $deletar = "DELETE FROM historico_baia WHERE id = '$idb'";
        $salvar = mysqli_query($conexao, $deletar);
        $atualiza = "UPDATE galpao SET qtde_baias = '$menos_baia', total_porcos = '$menos_porcos' WHERE id = '$id_galpao'";
        $salvar = mysqli_query($conexao, $atualiza);
        header('Location: lista_baia_galpao.php');
    endif;
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
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
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-success" type="submit" name="btn-submit"> Mudar Dados da Baia </button>
                            <button class="btn btn-outline-danger" type="submit" name="btn-delet"> Deletar Baia </button>
                        </div>
                        <div class="btn-group" role="group">
                            <a href="../movimentacao/movimentar.php" class="btn btn-outline-primary btn-sm"> Movimentar animais </a>
                            <a href="../movimentacao/alimentar_baia.php" class="btn btn-outline-primary btn-sm"> Alimentar / Vacinar Baia </a>
                        </div>
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