<?php
    include '../../controladores/autenticacao_usuario.php';

    //Codigo responsavel por inserir dados na tabela estoque

    if(isset($_POST['btn-submit'])):
        $idp = mysqli_escape_string($conexao, $_POST['produtos']);
        $qtde = mysqli_escape_string($conexao, $_POST['qtde']);
        $nf = mysqli_escape_string($conexao, $_POST['nf']);
        $lote = mysqli_escape_string($conexao, $_POST['lote']);
        $forn = mysqli_escape_string($conexao, $_POST['fornecedor']);
        $compra = mysqli_escape_string($conexao, $_POST['datCom']);
        $chegada = mysqli_escape_string($conexao, $_POST['datChe']);
        $venci = mysqli_escape_string($conexao, $_POST['venci']);
        $preco = mysqli_escape_string($conexao, $_POST['pu']);

        $sql = "INSERT INTO estoque(id_produto, qtde, data_hora, id_usuario, retirada, nf, lote, id_fonecedor, data_compra, data_chegada
        vencimento, preco) VALUES ('$idp', '$qtde', now(), '$id', 0, '$nf', '$lote', '$forn', '$compra', '$chegada', '$venci', '$preco')";
        $salvar = mysqli_query($conexao, $sql);

        $sql = "SELECT * FROM estoque WHERE data_hora = (SELECT max(data_hora) FROM estoque WHERE id_produto = '$idp')";
        $rs = mysqli_query($conexao, $sql);
        $es = mysqli_fetch_array($rs);

        $sql = "SELECT * FROM item WHERE id = '$idp'";
        $rs = mysqli_query($conexao, $sql);
        $it = mysqli_fetch_array($rs);

        $mais = $it['qtde'] + $es['qtde'];
        $sql = "UPDATE item SET qtde = '$mais' WHERE id = '$idp'";
        $rs = mysqli_query($conexao, $sql);

        header('Location: ../geral/estoque.php');
    endif;

    //

    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Entrada no Estoque </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">

                    <!-- Formulario para dar entrada no estoque -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Entrada de Estoque </h1>

                        <label for="n" class="sr-only"> Número da Nota Fiscal: </label>
                        <input type="text" name="nf" id="n" class="form-control" placeholder="Nota Fiscal" required>

                        <label for="l" class="sr-only"> Lote: </label>
                        <input type="text" name="lote" id="l" class="form-control" placeholder="Lote" required>

                        <label for="item"> Produtos: </label>
                        <select class="form-control" name="produtos" id="item">

                            <option values=""> Selecione </option>

                            <!-- Option com todos os produtos cadastrados no sistema -->

                            <?php 
                                $item = mysqli_query($conexao, "SELECT * FROM item");
                                while($it = mysqli_fetch_array($item))
                                {
                            ?>

                            <option value="<?php echo $it['id']; ?>"> <?php echo $it['nome'] ?> </option>

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="q" class="sr-only"> Quantidade: </label>
                        <input type="text" name="qtde" id="q" class="form-control" placeholder="Quantidade" required>

                        <label for="forn"> Fornecedor: </label>
                        <select class="form-control" name="fornecedor" id="forn">

                            <option values=""> Selecione </option>

                            <!-- Option com todos os fornecedores cadastrados no sistema -->

                            <?php 
                                $forn = mysqli_query($conexao, "SELECT * FROM fornecedor");
                                while($fo = mysqli_fetch_array($forn))
                                {
                            ?>

                            <option value="<?php echo $fo['id']; ?>"> <?php echo $fo['fantasia'] ?> </option>

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="dcom"> Data Compra: </label>
                        <input type="date" name="datCom" id="dcom" class="form-control" required>

                        <label for="dc"> Data Chegada: </label>
                        <input type="date" name="datChe" id="dc" class="form-control" required>

                        <label for="v"> Vencimento: </label>
                        <input type="date" name="venci" id="v" class="form-control" required>

                        <label for="p" class="sr-only"> Preço Unitario: </label>
                        <input type="text" name="pu" id="p" class="form-control" placeholder="Preço Unitario" required>

                        <div class="btn-group">
                            <button class="btn btn-lg btn-outline-success btn-block" type="submit" name="btn-submit"> Dar entrada </button>
                            <a class="btn btn-lg btn-outline-primary" href="../geral/estoque.php"> Voltar </a>
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