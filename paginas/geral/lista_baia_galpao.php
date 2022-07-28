<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';

    unset($_SESSION['dg']);
    unset($_SESSION['db']);
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Lista de Baias e Galpões </title>
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

                    <!-- Formulario para selecionar algum Galpão ou baia -->

                    <form class="form-signin" method="POST" action="../../controladores/selecione_galpao.php">
                        <h6 class=" text-muted"> Galpões </h6>
                        
                        <!-- Select com todas as baias e galpões cadastrados no Banco de Dados -->

                        <label for="galpao"> Selecione um Galpão ou Baia </label>
                        <select class="form-control" name="gb" id="galpao">
                            <option values=""> Selecione </option>

                            <!-- Opção com os galpões cadastrados no Banco de dados -->

                            <?php 
                                $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                                while($gp = mysqli_fetch_array($galpoes))
                                {
                                    $idg = $gp['id'];
                            ?>

                            <option value="<?php echo $gp['identificacao']; ?>"> <?php echo $gp['identificacao']; ?> </option>
                            
                            <!-- -->
                            <!-- Parte responsavel pelo cadastro automatico das baias e opção com as baias cadastradas -->

                            <?php 
                                $baia = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$idg'");
                                while($ba = mysqli_fetch_array($baia))
                                { ?>

                            <option value="<?php echo $ba['identificacao']; ?>">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                            <?php echo $ba['identificacao'] ?> </option>
                            
                            <!-- -->

                            <?php 
                                } 
                            } ?>

                        </select>
                        
                        <!-- -->

                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-dados"> Ver Dados </button>
                        <a class="btn btn-lg btn-outline-warning btn-block" href="../cadastros/cadastro_galpoes.php"> Cadastrar Galpão </a>
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