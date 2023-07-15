<?php
include '../../controllers/autenticacao_usuario.php';

//Script para alteração do estoque

if (isset($_POST['btn-submit'])):
    $basva = mysqli_escape_string($conexao, $_POST['b']);
    $prod = mysqli_escape_string($conexao, $_POST['g']);
    $qtde = mysqli_escape_string($conexao, $_POST['q']);

    $sql = "SELECT * FROM estoque WHERE id = '$prod'";
    $rs = mysqli_query($conexao, $sql);
    $it = mysqli_fetch_array($rs);

    $menos = $it['qtde'] - $qtde;

    if ($menos <= 0):

        //Exibição de um erro, caso a quantidade do produto seja insuficiente

        $sem = "<script> var sem = 'Quantidade insuficiente, tente novamente.'; </script>";
        echo $sem;
        echo "<script> alert(sem); </script>";

        //

    else:
        $idForn = $estoq['id_fornecedor'];
        $lote = $esotq['lote'];
        $nt = $estoq['nt'];
        $preco = $estoq['preco'];
        $dataChe = $estoq['data_chegada'];
        $dataCom = $estoq['data_compra'];
        $vencimento = $estoq['vencimento'];

        $sql = "INSERT INTO historico_itens_baia(id_baia, id_usuario, id_item, qtde, data_hora) 
            VALUES ('$basva', '$id', '$prod', '$qtde', now())";
        $salvar = mysqli_query($conexao, $sql);

        $sql = "INSERT INTO estoque(id_produto, qtde, data_hora, id_usuario, retirada, id_fornecedor, lote, nt, preco, data_chegada,
            data_compra, vencimento) VALUES ('$prod', '$qtde', now(), '$id', 1, '$idForn', '$lote', '$nt', '$preco', '$dataChe', '$dataCom', 
            '$vencimento')";
        $rs = mysqli_query($conexao, $sql);

        header('Location: ../geral/lista_baia_galpao.php');
    endif;
endif;

//

include '../../controllers/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title> Alimentar / Vacinar Baias </title>
    <?php include '../../includes/head.php'; ?>
</head>

<body class="gradiente">
    <div class="container">
        <?php include $bs; ?>
        <div class="row">
            <?php include $bl; ?>
            <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">

                <!-- Formulario para informar a baia, para onde deseja movimentar, e a quantidade do produto selecionado -->

                <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="baia"> Baia a ser Vacinada / Alimentada: </label>
                    <select class="form-control" name="b" id="baia">

                        <option value=""> Selecione uma opção </option>

                        <!-- Option com todas as baias e galpões existentes no Banco de Dados -->

                        <?php
                        $baias = mysqli_query($conexao, "SELECT * FROM baia");
                        while ($ba = mysqli_fetch_array($baias)) {
                            ?>

                            <option value="<?php echo $ba['id']; ?>"><?php echo $ba['identificacao'] ?></option>

                        <?php } ?>

                        <!-- -->

                    </select>

                    <label for="produtos"> Produtos: </label>
                    <select class="form-control" name="g" id="produtos">

                        <option value=""> Selecione uma opção </option>

                        <!-- Option com os produtos que cada cargo pode alterar -->

                        <?php
                        $cargo = $dados['cargo'];
                        if ($cargo == 1 || $cargo == 2):
                            $prod = mysqli_query($conexao, "SELECT * FROM item WHERE tipo = 1 OR tipo = 2");
                        else:
                            $prod = mysqli_query($conexao, "SELECT * FROM item WHERE tipo = 1");
                        endif;
                        while ($it = mysqli_fetch_array($prod)) {

                            //Script para verificar a quantidade dos produtos
                        
                            $qtde = 0;

                            $idProd = $it['id'];
                            $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 0");
                            while ($estEnt = mysqli_fetch_array($estoque)) {
                                $qtde += $estEnt['qtde'];
                            }

                            $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 1");
                            while ($estRet = mysqli_fetch_array($estoq)) {
                                $qtde -= $estRet['qtde'];
                            }

                            //
                        
                            $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 0");
                            $estEnt = mysqli_fetch_array($estoque);

                            if ($qtde <= 0):
                                continue;
                            endif;

                            $dataVencimento = mysqli_query($conexao, "SELECT YEAR(vencimento) AS ano, MONTH(vencimento) AS mes, 
                                    DAY(vencimento) AS dia FROM estoque WHERE id_produto = '$idProd'");
                            $dataVenc = mysqli_fetch_array($dataVencimento);

                            $diaVenc = $dataVenc['dia'];
                            $mesVenc = $dataVenc['mes'];
                            $anoVenc = $dataVenc['ano'];
                            $dataConcatenada = $diaVenc . "/" . $mesVenc . "/" . $anoVenc;
                            ?>

                            <option value="<?php echo $estEnt['id']; ?>"> <?php echo $it['nome'] ?> - Lote <?php echo $estEnt['lote']; ?> -
                                <?php echo $dataConcatenada; ?></option>

                            <!-- -->

                        <?php } ?>

                    </select>

                    <label for="qtde"> Quantidade: </label>
                    <input type="text" name="q" id="qtde" class="form-control" placeholder="Quantidade" required>

                    <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Alimentar /
                        Vacinar Baia </button>
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