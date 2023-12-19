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
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light pre-scrollable">
                    <h4 class="text-muted"> Estoque </h4>

                    <!-- Tabela com todos os produtos cadastrados no estoque -->

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> # </th>
                                <th scope="col"> Nome </th>
                                <th scope="col"> Fabricante </th>
                                <th scope="col"> Quantidade </th>
                            </tr>
                        </thead>
                        <tbody>
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

                                    $estoq = mysqli_query($conexao, "SELECT * FROM estoque WHERE id_produto = '$idProd' AND retirada = 1");
                                    while($estRet = mysqli_fetch_array($estoq))
                                    {
                                        $qtde -= $estRet['qtde'];
                                    }

                                    if($qtde <= 0):
                                        continue;
                                    endif;
                                    
                                    // ?>
                                    
                                <tr>
                                    <th scope="row"><?php echo $it['id']; ?></th>
                                    <td><a href="../geral/produto.php?id=<?php echo $it['id']; ?>"> <?php echo $it['nome']; ?> </a></td>
                                    <td><?php echo $it['fabricante']; ?></td>
                                    <td><?php echo $qtde; ?>  <?php echo $it['unidade']?></td>
                                </tr>
                            <?php } ?>  
                        </tbody>
                    </table>

                    <!-- -->
                    
                </div>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <a href="../cadastros/cadastrar_produto.php" class="btn btn-outline-primary"> Cadastrar Produto </a>
                    <a href="../movimentacao/entrada.php" class="btn btn-outline-success"> Entrada </a>
                    <a href="../movimentacao/retirada.php" class="btn btn-outline-danger"> Retirada </a>            
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>