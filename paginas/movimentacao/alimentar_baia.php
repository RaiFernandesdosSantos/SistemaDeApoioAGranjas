<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $basva = mysqli_escape_string($conexao, $_POST['b']);
        $prod = mysqli_escape_string($conexao, $_POST['g']);
        $qtde = mysqli_escape_string($conexao, $_POST['q']);
        $sql = "INSERT INTO historico_itens_baia(id_baia, id_usuario, id_item, qtde, dara_hora) 
        VALUES ('$basva', '$id', '$prod', '$qtde', now())";
        $salvar = mysqli_query($conexao, $sql);
        $sql = "INSERT INTO estoque(id_produto, id_usuario, qtde, data_hora, retirada) VALUES ('$basva', '$id', '$qtde', now(), 1)";
        $rs = mysqli_query($conexao, $sql);
        $sql = "SELECT * FROM item WHERE id = '$prod'";
        $rs = mysqli_query($conexao, $sql);
        $it = mysqli_fetch_array($rs);
        $menos = $it['qtde'] - $qtde;
        $sql = "UPDATE item SET qtde = '$menos' WHERE id = '$prod'";
        header('Location: ../geral/lista_bai_galpao.php');
    endif;
    include '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Alimentar / Vacinar Baias </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="baia"> Baia a ser Vacinada / Alimentada: </label>
                        <select class="form-control" name="b" id="baia">
                            <option value=""> Selecione uma opção </option>
                            <?php 
                                $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                                while($gp = mysqli_fetch_array($galpoes))
                                {
                                    $gpid = $gp['id'];
                                    $baias = mysqli_query($conexao, "SELECT * FROM baia WHERE id_galpao = '$gpid'");
                                    while($ba = mysqli_fetch_array($baias))
                                    {
                            ?>
                            <option value="<?php echo $ba['id']; ?>" id="b<?php echo $gp['id']; ?>"><?php echo $ba['identificacao'] ?></option>
                            <?php } ?>
                            <?php } ?>
                        </select>
                        <label for="galpoes"> Produtos: </label>
                        <select class="form-control" name="g" id="galpoes">
                            <option value=""> Selecione uma opção </option>
                            <?php 
                                $prod = mysqli_query($conexao, "SELECT * FROM produtos WHERE tipo = 1 OR tipo = 2");
                                while($pr = mysqli_fetch_array($prod))
                                {
                            ?>
                            <option value="<?php echo $pr['id']; ?>"><?php echo $pr['nome'] ?></option>
                            <?php } ?>
                        </select>
                        <label for="qtde"> Quantidade: </label>
                        <input type="text" name="q" id="qtde" class="form-control" placeholder="Quantidade" required>
                        <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Alimentar / Vacinar Baia </button>
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