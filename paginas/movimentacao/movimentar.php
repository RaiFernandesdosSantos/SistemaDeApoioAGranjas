<?php
    include '../../controladores/autenticacao_usuario.php';
    include '../../controladores/verificar_cargo.php';

    //Script para alterar o historico da baia selecionada

    if(isset($_POST['btn-submit'])):
        $idbo = mysqli_escape_string($conexao, $_POST['baiaOrig']);
        $idbd = mysqli_escape_string($conexao, $_POST['baiaDest']);
        $qtde = mysqli_escape_string($conexao, $_POST['q']);

        $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbo' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE 
        id_baia = '$idbo') AND retirada = 0";
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

        elseif($qtde > $dest['capacidade_total_porcos']):

            //Erro caso a baia não suporte a quantidade de porcos

            $erro2 = "<script> var erro2 = 'Quantidade de porcos maior do que a capacidade permitida pela baia.'; </script>";
            echo $erro2;
            echo "<script> alert(erro1); </script>";

            //

        else:
            $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idbd' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE 
            id_baia = '$idbd') AND retirada = 0";
            $rs = mysqli_query($conexao, $sql);
            $hbd = mysqli_fetch_array($rs);

            $menos = $qp['qtde_porcos'] - $qtde;
            $mais = $hbd['qtde_porcos'] + $qtde;
            $mpo = $qp['media_peso'];
            $mpd = $hbd['media_peso'];

            $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso, retirada) 
            VALUES ('$idbo', '$id', now(), '$menos', '$mpo', 0)";
            $salvar = mysqli_query($conexao, $sql);

            $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso, retirada) 
            VALUES ('$idbo', '$id', now(), '$qtde', '$mpo', 1)";
            $salvar = mysqli_query($conexao, $sql);

            $sql = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso, retirada) 
            VALUES ('$idbd', '$id', now(), '$mais', '$mpd', 0)";
            $salvar = mysqli_query($conexao, $sql);

            header('Location: ../geral/lista_baia_galpao.php');
        endif;  
    endif;

    //
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
                        <label for="baiao"> Mover animais de: </label>
                        <select class="form-control" name="baiaOrig" id="baiao">

                            <option value=""> Selecione uma opção </option>

                            <!-- Loop para separar as baias por galpões -->

                            <?php 
                                $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                                while($gp = mysqli_fetch_array($galpoes))
                                {
                                    $gpid = $gp['id'];

                                    if($gp['funcao'] == 1):
                                        $f = "Maternidade";
                                        elseif($gp['funcao'] == 2):
                                            $f = "Creche";
                                        elseif($gp['funcao'] == 3):
                                            $f = "Terminação";
                                        elseif($gp['funcao'] == 4):
                                            $f = "Quarentena";
                                    endif;
                            ?>
                            
                            <!-- Option com todas as baias cadastradas -->

                            <?php 
                                $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                                while($ba = mysqli_fetch_array($baias))
                                {
                            ?>

                            <option value="<?php echo $ba['id']; ?>" id="b<?php echo $gpid; ?>"><?php echo $ba['identificacao']; ?> - 
                            <?php echo $f; ?></option>

                            <?php } 
                            } ?>
                            
                            <!-- -->

                        </select>

                        <label for="baiad"> Mover animais para: </label>
                        <select class="form-control" name="baiaDest" id="baiad">

                            <option value=""> Selecione uma opção </option>
                            
                            <!-- Loop para separar as baias por galpões -->

                            <?php 
                                $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                                while($gp = mysqli_fetch_array($galpoes))
                                {
                                    $gpid = $gp['id'];

                                    if($gp['funcao'] == 1):
                                        $f = "Maternidade";
                                        elseif($gp['funcao'] == 2):
                                            $f = "Creche";
                                        elseif($gp['funcao'] == 3):
                                            $f = "Terminação";
                                        elseif($gp['funcao'] == 4):
                                            $f = "Quarentena";
                                    endif;
                            ?>
                            
                            <!-- Option com todas as baias cadastradas -->
                            
                            <?php 
                                $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                                while($ba = mysqli_fetch_array($baias))
                                {
                            ?>

                            <option value="<?php echo $ba['id']; ?>" id="b<?php echo $gpid; ?>"><?php echo $ba['identificacao']; ?> - 
                            <?php echo $f; ?></option>

                            <?php } 
                            } ?>
                            
                            <!-- -->

                        </select>

                        <label for="qtde"> Quantidade de animais a ser movimentada: </label>
                        <input type="text" name="q" id="qtde" class="form-control" placeholder="Quantidade de animais movimentada" required>

                        <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Movimentar animais </button>
                        <a class="btn btn-outline-primary btn-block" href="../geral/pagina_restrita_gerente.php"> Voltar </a>
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