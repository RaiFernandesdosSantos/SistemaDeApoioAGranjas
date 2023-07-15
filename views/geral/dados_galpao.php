<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';

    //Procura e Armazenagem dos dados do Galpão selecionado

    $idg = $_SESSION['dg'];
    $sql = "SELECT * FROM galpao WHERE id = '$idg'";
    $rs = mysqli_query($conexao, $sql);
    $dg = mysqli_fetch_array($rs);

    if($dg['funcao'] == 1):
        $f = "Maternidade";
        elseif($dg['funcao'] == 2):
            $f = "Creche";
        elseif($dg['funcao'] == 3):
            $f = "Terminação";
        elseif($dg['funcao'] == 4):
            $f = "Quarentena";
    endif;

    //
    //Parte responsavel pela alteração dos dados do Galpão

    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);

        $sql = "UPDATE galpao SET identificacao = '$identificacao', funcao = '$funcao' WHERE id = '$idg'";
        $salvar = mysqli_query($conexao, $sql);

        header('Location: lista_baia_galpao.php');
    endif;

    //  
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Dados dos Galpões </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">

                    <!-- Formulario com os dados do Galpão selecionado -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <table class="table">
                            <tbody>
                                <tr>
                                    
                                    <label for="iden"> Identificação: </label>
                                    <input type="text" name="i" id="iden" class="form-control" value="<?php echo $dg['identificacao']; ?>">
                                </tr>

                                <tr>
                                    <th scope="row"> Quantidade de Baias: </th>
                                    <td> <?php echo $dg['qtde_baias']; ?> </td>
                                </tr>

                                <tr>
                                    <th scope="row"> Total Atual de Porcos </th>
                                    <td> <?php echo $dg['total_porcos']; ?> </td>
                                </tr>

                                <tr>

                                    <!-- Select com os tipos de Galpões para caso haja alguma alteração -->

                                    <label for="funcao"> Função do Galpão: </label>
                                    <select class="form-control" name="f" id="funcao">
                                        <option value="<?php echo $dg['funcao']; ?>"> <?php echo $f; ?> </option>
                                        <option value="1"> Maternidade </option>
                                        <option value="2"> Creche </option>
                                        <option value="3"> Terminação </option>
                                        <option value="4"> Quarentena </option>
                                    </select>

                                    <!-- -->

                                </tr>
                            </tbody>
                        </table>

                        <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Mudar Dados do Galpão </button>

                        <a href="../../controladores/deletar_galpao.php?id=<?php echo $idg;?>" class="btn btn-outline-danger btn-block"> 
                        Deletar Galpão </a>

                        <a href="../movimentacao/movimentar.php" class="btn btn-outline-primary btn-block"> Movimentar animais </a>
                        <a class="btn btn-outline-primary btn-block" href="../geral/lista_baia_galpao.php"> Voltar </a>
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