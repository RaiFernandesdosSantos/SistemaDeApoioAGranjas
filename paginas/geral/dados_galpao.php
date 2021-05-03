<?php
    include '../../controladores/autenticacao_usuario.php';
    $sql2 = "SELECT * FROM galpao WHERE identificacao = '$nome'";
    $r1 = mysqli_query($conexao, $sql2);
    $dg = mysqli_fetch_array($r1);
    $id_galpao = $dg['id'];
    $sql = "SELECT * FROM baia WHERE id = '$id_galpao'";
    $r2 = mysqli_query($conexao, $sql);
    $db = mysqli_fetch_array($r2);
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);
        $sql = "UPDATE galpao SET identificacao = '$identificacao', funcao = '$funcao' WHERE identificacao = '$nome'";
        $salvar = mysqli_query($conexao, $sql);
    elseif(isset($_POST['btn-delet'])):
        $deletar = "DELETE FROM galpao WHERE identificacao = '$nome'";
        $salvar = mysqli_query($conexao, $deletar);
        $deletar_baia = "DELETE FROM baia WHERE id_galpao = '$id_galpao'";
        $salvar = mysqli_query($conexao, $deletar_baia);
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
                        <button class="btn btn-outline-success btn-sm" type="submit" name="btn-submit"> Mudar Dados do Galpão </button>
                        <button class="btn btn-outline-danger btn-sm" type="submit" name="btn-delet"> Deletar Galpão </button>
                        <a href="../movimentacao/movimentar.php" class="btn btn-outline-primary"> Movimentar animais </a>
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