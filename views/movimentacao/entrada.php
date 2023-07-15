<?php
    include '../../controllers/autenticacao_usuario.php';
    require_once '../../controllers/verificar_cargo.php';

    if(isset($_POST['btn-submit'])):
        $nf = mysqli_escape_string($conexao, $_POST['nf']);
        $lote = mysqli_escape_string($conexao, $_POST['lote']);
        $forn = mysqli_escape_string($conexao, $_POST['fornecedor']);
        $preco = mysqli_escape_string($conexao, $_POST['pu']);
        $idp = mysqli_escape_string($conexao, $_POST['produtos']);
        $qtde = mysqli_escape_string($conexao, $_POST['qtde']);
        $venci = mysqli_escape_string($conexao, $_POST['venci']);

        $sql = "INSERT INTO estoque (id_produto, id_usuario, qtde, data_hora, retirada, nt, lote, id_fornecedor, data_compra, data_chegada, 
        vencimento, preco) VALUES ('$idp', '$id', '$qtde', now(), 0, '$nf', '$lote', '$forn', now(), now(), '$venci', '$preco');";
        $salvar = mysqli_query($conexao, $sql);

        header('Location: ../geral/estoque.php');
    endif;
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

                        <label for="nota" class="sr-only"> Número da Nota Fiscal: </label>
                        <input type="text" name="nf" id="nota" class="form-control" placeholder="Nota Fiscal" required>

                        <label for="l" class="sr-only"> Lote: </label>
                        <input type="text" name="lote" id="l" class="form-control" placeholder="Lote" required>

                        <label for="forn"> Fornecedor: </label>
                        <select class="form-control" name="fornecedor" id="forn">

                            <option values=""> Selecione </option>

                            <!-- Option com todos os fornecedores cadastrados no sistema -->

                            <?php 
                                $forn = mysqli_query($conexao, "SELECT * FROM fornecedor");
                                while($fo = mysqli_fetch_array($forn))
                                {
                            ?>

                            <option value="<?php echo $fo['id']; ?>"> <?php echo $fo['fantasia']; ?> </option>

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="p" class="sr-only"> Preço Unitario: </label>
                        <input type="text" name="pu" id="p" class="form-control" placeholder="Preço Unitario" required>

                        <label for="item"> Produtos: </label>
                        <select class="form-control" name="produtos" id="item">

                            <option values=""> Selecione </option>

                            <!-- Option com todos os produtos cadastrados no sistema -->

                            <?php 
                                $item = mysqli_query($conexao, "SELECT * FROM item");
                                while($it = mysqli_fetch_array($item))
                                {
                            ?>

                            <option value="<?php echo $it['id']; ?>"> <?php echo $it['nome']; ?> </option>

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="q" class="sr-only"> Quantidade: </label>
                        <input type="text" name="qtde" id="q" class="form-control" placeholder="Quantidade" required>

                        <label for="v"> Vencimento: </label>
                        <input type="date" name="venci" id="v" class="form-control" required>

                        <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Dar entrada </button>
                        <a class="btn btn-outline-primary btn-block" href="../geral/estoque.php"> Voltar </a>
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