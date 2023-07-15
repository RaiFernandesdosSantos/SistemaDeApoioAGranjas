<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';

    $idIt = $_GET['id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Estoque </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light pre-scrollable">
                    <h4 class="text-muted"> Estoque </h4>

                    <!-- Tabela com todos os lotes diferentes do produto selecionado -->

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> Lote </th>
                                <th scope="col"> Nome </th>
                                <th scope="col"> Quantidade </th>
                                <th scope="col"> Vencimento </th>
                                <th scope="col"> Preço Unitario </th>
                                <th scope="col"> Preço Total </th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Parte responsavel pela procura e impressao dos dados dos produtos na tela -->

                            <?php 
                                $estoque = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idIt' ORDER BY vencimento");
                                
                                while($est = mysqli_fetch_array($estoque))
                                {
                                    $item = mysqli_query($conexao, "SELECT * FROM item WHERE id = '$idIt'");
                                    $it = mysqli_fetch_array($item);

                                    $quantidade = 0;

                                    $estoq = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idIt' AND retirada = 0");
                                    while($estEnt = mysqli_fetch_array($estoq))
                                    {
                                        $quantidade += $estEnt['qtde'];
                                    }

                                    $estoq = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idIt' AND retirada = 1");
                                    while($estRet = mysqli_fetch_array($estoq))
                                    {
                                        $quantidade -= $estRet['qtde'];
                                    }

                                    $lote = $est['lote'];
                                    $nt = $est['nt'];
                                    $dateChegada = $est['data_chegada'];

                                    $dataVencimento = mysqli_query($conexao, "SELECT YEAR(vencimento) AS ano, MONTH(vencimento) AS mes, 
                                    DAY(vencimento) AS dia FROM estoque WHERE id_produto = '$idIt' AND lote = '$lote' AND nt = '$nt' AND
                                    data_chegada = '$dateChegada'");
                                    $dataVenc = mysqli_fetch_array($dataVencimento);

                                    $diaVenc = $dataVenc['dia'];
                                    $mesVenc = $dataVenc['mes'];
                                    $anoVenc = $dataVenc['ano'];
                                    $dataConcatenada = $diaVenc ."/". $mesVenc ."/". $anoVenc;

                                    $total = $est['preco'] * $est['qtde'];
                                    $unitario = $est['preco'];
                                    $totalFormatado = number_format($total, 2, ",", ".");
                                    $unitarioFormatado = number_format($unitario, 2, ",", ".");
                            ?>
                            <tr>
                                <th scope="row"><?php echo $est['lote']; ?></th>
                                <td><?php echo $it['nome']; ?></td>

                                <?php if($est['retirada'] == 1): ?>
                                    <td style="color: red"> - <?php echo $est['qtde']; ?>  <?php echo $it['unidade']?></td>
                                <?php else: ?>
                                    <td><?php echo $est['qtde']; ?>  <?php echo $it['unidade']?></td>
                                <?php endif; ?>

                                <td><?php echo $dataConcatenada; ?></td>

                                <?php if($est['retirada'] != 1): ?>
                                    <td>R$ <?php echo $unitarioFormatado; ?></td>
                                    <td>R$ <?php echo $totalFormatado; ?></td>
                                <?php else: ?>
                                    <td> </td>
                                    <td> </td>
                                <?php endif; ?>

                            </tr>
                            <?php } ?>
                            
                            <!-- -->

                        </tbody>
                    </table>

                    <!-- -->

                </div>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <table class="table">
                        <thead>
                            <th> Estoque Restante </th>
                            <th><?php echo $it['nome']; ?></th>
                            <th><?php echo $quantidade; ?> <?php echo $it['unidade'];?></th>
                        </thead>
                    </table>
                    
                    <a href="../geral/estoque.php" class="btn btn-md btn-outline-primary"> Voltar </a>
                    <a href="../movimentacao/entrada.php" class="btn btn-md btn-outline-success"> Entrada </a>
                    <a href="../../controladores/deletar_produto.php?id=<?php echo $it['id']; ?>" 
                    class="btn btn-outline-danger"> Deletar Produto </a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>