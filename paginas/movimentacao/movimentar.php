<?php
    include '../../controladores/autenticacao_usuario.php';

    //Script para alterar o historico da baia selecionada

    if(isset($_POST['btn-submit'])):
        $idbo = mysqli_escape_string($conexao, $_POST['b']);
        $idbd = mysqli_escape_string($conexao, $_POST['g']);
        $qtde = mysqli_escape_string($conexao, $_POST['q']);
        $motivo = mysqli_escape_string($conexao, $_POST['m']);

        $bo = mysqli_query($conexao, "SELECT * FROM baia WHERE id = '$idbo'");
        $orig = mysqli_fetch_array($bo);

        $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbo' AND data_hora = (SELECT max(data_hora) FROM historico_baia 
        WHERE id_baia = '$idbo')";
        $rs = mysqli_query($conexao, $sql);
        $qp = mysqli_fetch_array($rs);

        $bd = mysqli_query($conexao, "SELECT * FROM baia WHERE id = '$idbd'");
        $dest = mysqli_fetch_array($bd);

        if($qtde > $qp['qtde_porcos']):

            //Erro caso a quantidade de porcos for insuficiente
            
            $erro1 = "<script> var erro1 = 'Quantidade de porcos insuficiente.'; </script>";
            echo $erro1;
            echo "<script> alert(erro1); </script>";

            //

            if($qtde > $dest['capacidade_total_porcos']):

                //Erro caso a baia não suporte a quantidade de porcos

                $erro2 = "<script> var erro2 = 'Quantidade de porcos maior do que a capacidade permitida pela baia.'; </script>";
                echo $erro2;
                echo "<script> alert(erro1); </script>";

                //

            else:
                $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbo' AND data_hora = (SELECT max(data_hora) FROM historico_baia 
                WHERE id_baia = '$idbo')";
                $rs = mysqli_query($conexao, $sql);
                $hbo = mysqli_fetch_array($rs);

                $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbd' AND data_hora = (SELECT max(data_hora) FROM historico_baia 
                WHERE id_baia = '$idbo')";
                $rs = mysqli_query($conexao, $sql);
                $hbd = mysqli_fetch_array($rs);

                $menos = $hbo['qtde_porcos'] - $qtde;
                $mais = $hbd['qtde_porcos'] + $qtde;
                $mpo = $hbo['media_peso'];
                $mpd = $hbd['media_peso'];

                $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) 
                VALUES ('$idbo', '$id', now(), '$menos', '$mpo', '$motivo')";
                $salvar = mysqli_query($conexao, $sql);

                $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) 
                VALUES ('$idbd', '$id', now(), '$mais', '$mpd', '$motivo')";
                $salvar = mysqli_query($conexao, $sql);

                header('Location: movimentar.php');
            endif;
        endif;  
    endif;

    //

    include '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Movimentação de Animais </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">

                    <!-- Formulario para movimentar os animais entre as baias selecionadas -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="baia"> Mover animais de: </label>
                        <select class="form-control" name="b" id="baia">

                            <option value=""> Selecione uma opção </option>

                            <!-- Loop para separar as baias por galpões -->

                            <?php 
                                $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                                while($gp = mysqli_fetch_array($galpoes))
                                {
                                    $gpid = $gp['id'];
                            ?>

                            <label for="b<?php echo $gp['id']; ?>"><?php echo $gp['identificacao']; ?></label>
                            
                            <!-- Option com todas as baias cadastradas -->

                            <?php 
                                $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                                while($ba = mysqli_fetch_array($baias))
                                {
                            ?>

                            <option value="<?php echo $ba['id']; ?>" id="b<?php echo $gp['id']; ?>"><?php echo $ba['identificacao'] ?> - 
                            <?php echo $gp['funcao']?></option>

                            <?php } ?>
                            
                            <!-- -->

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="galpoes"> Mover animais para: </label>
                        <select class="form-control" name="g" id="galpoes">

                            <option value=""> Selecione uma opção </option>
                            
                            <!-- Loop para separar as baias por galpões -->

                            <?php 
                                $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                                while($gp = mysqli_fetch_array($galpoes))
                                {
                                    $gpid = $gp['id'];
                            ?>

                            <label for="g<?php echo $gp['id']; ?>"><?php echo $gp['identificacao']; ?></label>
                            
                            <!-- Option com todas as baias cadastradas -->
                            
                            <?php 
                                $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                                while($ba = mysqli_fetch_array($baias))
                                {
                            ?>

                            <option value="<?php echo $ba['id']; ?>" id="g<?php echo $gp['id']; ?>"><?php echo $ba['identificacao'] ?> - 
                            <?php echo $gp['funcao'] ?></option>

                            <?php } ?>
                            
                            <!-- -->

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="qtde"> Quantidade de animais a ser movimentada: </label>
                        <input type="text" name="q" id="qtde" class="form-control" placeholder="Quantidade de animais movimentada" required>

                        <label for="motivo"> Motivo da movimentação: </label>
                        <input type="text" name="m" id="motivo" class="form-control" placeholder="Motivo da Movimentação" required>

                        <div class="btn-group">
                            <button class="btn btn-lg btn-outline-success" type="submit" name="btn-submit"> Movimentar animais </button>
                            <a class="btn btn-lg btn-outline-primary" href="../geral/lista_baia_galpao.php"> Voltar </a>
                        </div>
                    </form>

                    <!-- -->

                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>