<?php
    include '../../controladores/autenticacao_usuario.php';
    unset($_SESSION['dg']);
    unset($_SESSION['db']);
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
        <script src="js/jquery-3.5.1.js"></script>
        <script src="js/bootstrap.js"></script>
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="../../controladores/selecione_galpao.php">
                        <h6 class=" text-muted">
                            <span>Galpões</span>
                            <a class=" text-muted" href="../cadastros/cadastro_galpoes.php" aria-label="Cadastrar Galpão">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                            </a>
                        </h6>
                        <?php 
                            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                            while($gp = mysqli_fetch_array($galpoes))
                            {
                        ?>
                        <label for="galpao"> <?php echo $gp['identificacao']; ?> </label>
                        <select class="form-control" name="g<?php echo $gp['id']?>" id="galpao">
                            <option values=""> Selecione </option>
                            <option value="<?php echo $gp['id']; ?>"> <?php echo $gp['identificacao']; ?> </option>
                            <?php 
                                for($baias = $gp['qtde_baias']; $baias != 0; $baias--)
                                {
                                    $nome = "Baia".$baias."_".$gp['id'];
                                    $id_galpao = $gp['id'];
                                    $c_b = "INSERT INTO baia(id_galpao, identificacao, capacidade_total_porcos) VALUES ('$id_galpao', '$nome', 0)";
                                    $cadas_baias = mysqli_query($conexao, $c_b);
                                    $sql2 = "SELECT * FROM baia WHERE identificacao = '$nome'";
                                    $retorno = mysqli_query($conexao, $sql2);
                                    $dados_baia = mysqli_fetch_array($retorno);
                                    $id_baia = $dados_baia['id'];
                                    $conferir = "SELECT * FROM historico_baia WHERE id_baia = '$id_baia'";
                                    $r1 = mysqli_query($conexao, $conferir);
                            ?>
                            <option value="<?php echo $dados_baia['id']; ?>"> <?php echo $dados_baia['identificacao'] ?> </option>
                            <?php 
                                    if(mysqli_num_rows($r1) != 0):
                                        continue;
                                    else:
                                        $hb = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) VALUES ('$id_baia', '$id', now(), 0, 0)";
                                        $historico = mysqli_query($conexao, $hb);   
                                    endif;
                                } ?>
                        </select>
                        <?php } ?>
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-dados"> Ver Dados </button>
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