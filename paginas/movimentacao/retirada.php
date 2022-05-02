<?php
    include '../../controladores/autenticacao_usuario.php';

    //Scipt para retirada de produtos do estoque 

    if(isset($_POST['btn-submit'])):
        $ide = mysqli_escape_string($conexao, $_POST['produtos']);
        $q = mysqli_escape_string($conexao, $_POST['qtde']);

        $sql = "SELECT * FROM estoque WHERE id = '$ide'";
        $rs = mysqli_query($conexao, $sql);
        $estoq = mysqli_fetch_array($rs);

        $qm = $estoq['qtde'] - $q;

        if($qm <= 0):

            //Erro caso a quantidade for insuficiente

            $erro = "<script> var erro = 'Quantidade insuficiente, tente novamente.'; </script>";
            echo $erro;
            echo "<script> alert(erro); </script>";

            //

        else:
            $idForn = $estoq['id_fornecedor'];
            $lote = $esotq['lote'];
            $nt = $estoq['nt'];
            $preco = $estoq['preco'];
            $dataChe = $estoq['data_chegada'];
            $dataCom = $estoq['data_compra'];
            $vencimento = $estoq['vencimento'];

            $sql = "INSERT INTO estoque(id_produto, qtde, data_hora, id_usuario, retirada, id_fornecedor, lote, nt, preco, data_chegada,
            data_compra, vencimento) VALUES ('$idp', '$q', now(), '$id', 1, '$idForn', '$lote', '$nt', '$preco', '$dataChe', '$dataCom', 
            '$vencimento')";
            $salvar = mysqli_query($conexao, $sql);

            header('Location: ../geral/estoque.php');
        endif;
    endif;

    //

    include '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Retirada no Estoque </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">

                    <!-- Formulario para informar o produto e a quantidade que deseja retirar -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Retirada de Estoque </h1>

                        <label for="item"> Produtos: </label>
                        <select class="form-control" name="produtos" id="item">

                            <option values=""> Selecione </option>

                            <!-- Option com todos os produtos cadastrados no estoque -->

                            <?php 
                                $item = mysqli_query($conexao, "SELECT * FROM item");
                                while($it = mysqli_fetch_array($item))
                                {

                                    //Script para verificar a quantidade dos produtos

                                    $qtde = 0;

                                    $idProd = $it['id'];
                                    $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 0");
                                    while($estEnt = mysqli_fetch_array($estoque))
                                    {
                                        $qtde += $estEnt['qtde'];
                                    }

                                    $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 1");
                                    while($estRet = mysqli_fetch_array($estoq))
                                    {
                                        $qtde -= $estRet['qtde'];
                                    }

                                    //

                                    $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 0");
                                    $estEnt = mysqli_fetch_array($estoque);

                                    if($qtde <= 0):
                                        continue;
                                    endif;
                            ?>

                            <option value="<?php echo $estEnt['id']; ?>"> <?php echo $it['nome'] ?> - <?php echo $estEnt['lote']; ?> - 
                            <?php echo $estEnt['vencimento']; ?></option>

                            <?php } ?>
                            
                            <!-- -->

                        </select>

                        <label for="q" class="sr-only"> Quantidade: </label>
                        <input type="text" name="qtde" id="q" class="form-control" placeholder="Quantidade" required>

                        <label for="m" class="sr-only"> Motivo: </label>
                        <input type="text" name="motivo" id="m" class="form-control" placeholder="Motivo" required>

                        
                        <button class="btn btn-lg btn-outline-danger btn-block" type="submit" name="btn-submit"> Retirar </button>
                        <a class="btn btn-lg btn-outline-primary btn-block" href="../geral/estoque.php"> Voltar </a>
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