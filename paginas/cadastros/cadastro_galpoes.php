<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
    
    //Script responsavel pela inserção dos dados no Banco de Dados

    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $baias = mysqli_escape_string($conexao, $_POST['qb']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);

        $sql = "INSERT INTO galpao(identificacao, qtde_baias, funcao, total_porcos) VALUES ('$identificacao', '$baias', '$funcao', 0)";
        $salvar = mysqli_query($conexao, $sql);

        for($b = $baias; $b != 0; $b--)
        {
            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao WHERE identificacao = '$identificacao'");
            $gp = mysqli_fetch_array($galpoes);

            $nome = "Baia"." ".$b." - Galpão ".$gp['id'];
            $id_galpao = $gp['id'];

            $c_b = "INSERT INTO baia(id_galpao, identificacao, capacidade_total_porcos) VALUES ('$id_galpao', '$nome', 40)";
            $cadas_baias = mysqli_query($conexao, $c_b);

            $sql = "SELECT * FROM baia WHERE identificacao = '$identificacao'";
            $rs = mysqli_query($conexao, $sql);
            $db = mysqli_fetch_array($rs);

            $id_baia = $db['id'];

            $hb = "INSERT INTO historico_baia(id_baia, id_usuario, data_hora, qtde_porcos, media_peso) VALUES 
            ('$id_baia', '$id', now(), 0, 0)";
            $historico = mysqli_query($conexao, $hb); 
        }

        header('Location: ../geral/lista_baia_galpao.php');
    endif;

    // ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro de Galpões </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">

                    <!-- Formulario para cadastro dos Galpões -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Galpões </h1>

                        <label for="identificacao" class="sr-only"> Identificação </label>
                        <input type="text" name="i" id="identificacao" class="form-control" placeholder="Identificação" required>

                        <label for="baias" class="sr-only"> Quantidade de Baias </label>
                        <input type="text" name="qb" id="baias" class="form-control" placeholder="Quantidade de Baias" required>

                        <!-- Select com os tipos de Galpões -->

                        <label for="funcao"> Informe a função desse galpão: </label>
                        <select class="form-control" name="f" id="funcao">
                            <option value=""> Selecione </option>
                            <option value="1"> Maternidade </option>
                            <option value="2"> Creche </option>
                            <option value="3"> Terminação </option>
                            <option value="4"> Quarentena </option>
                        </select>

                        <!-- -->
                        
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar Galpão </button>
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