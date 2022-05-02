<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
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
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <h4 class="text-muted"> Estoque </h4>

                    <!-- Tabela com todos os lotes diferentes do produto selecionado -->

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> Lote </th>
                                <th scope="col"> Nome </th>
                                <th scope="col"> Quantidade </th>
                                <th scope="col"> Vencimento </th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Parte responsavel pela procura e impressao dos dados dos produtos na tela -->
                            <?php 
                                $item = mysqli_query($conexao, "SELECT * FROM item");
                                while($it = mysqli_fetch_array($item))
                                {

                                    //Verifica se a quantidade não é igual a zero, caso for ele pula o produto

                                    if($it['qtde'] <= 0):
                                        continue;
                                    endif;

                                    //
                            ?>

                            <tr>
                                <th scope="row"><?php echo $it['lote']; ?></th>
                                <td><?php echo $it['nome']; ?></td>
                                <td><?php echo $it['qtde']; ?>  <?php echo $it['unidade']?></td>
                                <td><?php echo $it['vencimento']; ?></td>
                            </tr>

                            <?php } ?>
                            
                            <!-- -->

                        </tbody>
                    </table>

                    <!-- -->

                    <a href="../movimentacao/entrada.php" class="btn btn-outline-success"> Entrada </a>
                    <a href="../movimentacao/retirada.php" class="btn btn-outline-danger"> Retirada </a>
                    <a href="../geral/estoque.php" class="btn btn-outline-primary"> Voltar </a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>