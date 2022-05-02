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
                            ?>

                            <option value="<?php echo $gp['identificacao']; ?>"> <?php echo $gp['identificacao']; ?> </option>
                            
                            <!-- -->
                            <!-- Parte responsavel pelo cadastro automatico das baias e opção com as baias cadastradas -->

                            <?php 
                                for($baias = $gp['qtde_baias']; $baias != 0; $baias--)
                                {

                                    //Cadastro das Baias

                                    $nome = "Baia".$baias."_".$gp['id'];
                                    $id_galpao = $gp['id'];

                                    $c_b = "INSERT INTO baia(id_galpao, identificacao, capacidade_total_porcos) 
                                    VALUES ('$id_galpao', '$nome', 0)";
                                    $cadas_baias = mysqli_query($conexao, $c_b);

                                    //
                                    //Busca no Banco de Dados pelas baias cadastradas e array com os dados

                                    $sql2 = "SELECT * FROM baia WHERE identificacao = '$nome'";
                                    $retorno = mysqli_query($conexao, $sql2);
                                    $dados_baia = mysqli_fetch_array($retorno);

                                    $id_baia = $dados_baia['id'];
                                    $conferir = "SELECT * FROM historico_baia WHERE id_baia = '$id_baia'";
                                    $r1 = mysqli_query($conexao, $conferir);

                                    //
                            ?>

                            <option value="<?php echo $dados_baia['identificacao']; ?>"> <?php echo $dados_baia['identificacao'] ?> </option>
                            
                            <!-- -->

                            <?php 

                                    // Verficação do cadastro das baias e inserção dos primeiros dados na tabela do historico das baias

                                    if(mysqli_num_rows($r1) != 0):
                                        continue;
                                    else:
                                        $hb = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) 
                                        VALUES ('$id_baia', '$id', now(), 0, 0)";
                                        $historico = mysqli_query($conexao, $hb);   
                                    endif;

                                    //
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