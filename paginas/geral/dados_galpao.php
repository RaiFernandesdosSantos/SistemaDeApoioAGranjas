<?php
    include '../../controladores/autenticacao_usuario.php';
    $idg = $_SESSION['dg'];
    $sql = "SELECT * FROM galpao WHERE id = '$idg'";
    $rs = mysqli_query($conexao, $sql);
    $dg = mysqli_fetch_array($rs);
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);
        $sql = "UPDATE galpao SET identificacao = '$identificacao', funcao = '$funcao' WHERE id = '$idg'";
        $salvar = mysqli_query($conexao, $sql);
        header('Location: lista_baia_galpao.php');
    elseif(isset($_POST['btn-delet'])):
        $deletar = "DELETE FROM galpao WHERE id = '$idg'";
        $salvar = mysqli_query($conexao, $deletar);
        $deletar_baia = "DELETE FROM baia WHERE id_galpao = '$idg'";
        $salvar = mysqli_query($conexao, $deletar_baia);
        header('Location: lista_baia_galpao.php');
    endif;
    require_once '../../controladores/verificar_cargo.php';
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
                                    <label for="funcao"> Função do Galpão: </label>
                                    <select class="form-control" name="f" id="funcao">
                                        <option value="<?php echo $dg['funcao']; ?>"> <?php echo $dg['funcao']; ?> </option>
                                        <option value="Maternidade"> Maternidade </option>
                                        <option value="Creche"> Creche </option>
                                        <option value="Terminacao"> Terminação </option>
                                        <option value="Quarentena"> Quarentena </option>
                                    </select>
                                </tr>
                            </tbody>
                        </table>
                        <div class="btn-group" role="group">
                            <button class="btn btn-outline-success" type="submit" name="btn-submit"> Mudar Dados do Galpão </button>
                            <button class="btn btn-outline-danger" type="submit" name="btn-delet"> Deletar Galpão </button>
                        </div>
                        <a href="../movimentacao/movimentar.php" class="btn btn-outline-primary btn-block"> Movimentar animais </a>
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