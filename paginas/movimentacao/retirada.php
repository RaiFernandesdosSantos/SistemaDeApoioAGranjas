<?php
    include '../../controladores/autenticacao_usuario.php';
    $idp = $_SESSION['idp'];
    $sql = "SELECT * FROM item WHERE id = '$idp'";
    $rs = mysqli_query($conexao, $sql);
    $it = mysqli_fetch_array($rs);
    if(isset($_POST['btn-submit'])):
        $q = mysqli_escape_string($conexao, $_POST['num']);
        $qm = $it['qtde'] - $q;
        if($qm <= 0):
            $erro = "<script> var erro = 'Quantidade invalida, coloque outra quantidade.'; </script>";
            echo $erro;
            echo "<script> alert(erro); </script>";
        else:
            $sql = "INSERT INTO estoque(id_produto, qtde, data_hora, id_usuario, retirada) VALUES ('$idp', '$q', now(), '$id', 1)";
            $salvar = mysqli_query($conexao, $sql);
            $sql = "SELECT * FROM estoque WHERE data_hora = (SELECT max(data_hora) FROM estoque WHERE id_produto = '$idp')";
            $rs = mysqli_query($conexao, $sql);
            $es = mysqli_fetch_array($rs);
            $sql = "SELECT * FROM item WHERE id = '$idp'";
            $rs = mysqli_query($conexao, $sql);
            $it = mysqli_fetch_array($rs);
            $menos = $it['qtde'] - $es['qtde'];
            $sql = "UPDATE item SET qtde = '$menos' WHERE id = '$idp'";
            $rs = mysqli_query($conexao, $sql);
            header('Location: ../geral/estoque.php');
        endif;
    endif;
    include '../../controladores/verificar_cargo.php';
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
                        <h1 class="h3 mb-3 font-weight-normal"> Retirada de Estoque </h1>
                        <p><?php echo $it['nome']; ?></p>
                        <label for="q" class="sr-only"> Quantidade: </label>
                        <input type="text" name="num" id="q" class="form-control" placeholder="<?php echo $it['qtde']; ?>" required>
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Retirar </button>
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