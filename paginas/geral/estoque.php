<?php
    include '../../controladores/autenticacao_usuario.php';
    unset($_SESSION['idp']);
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
                    <h4 class="text-muted"> Estoque </h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> # </th>
                                <th scope="col"> Nome </th>
                                <th scope="col"> Fabricante </th>
                                <th scope="col"> Quantidade </th>
                                <th scope="col"> Ações </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $item = mysqli_query($conexao, "SELECT * FROM item");
                                while($it = mysqli_fetch_array($item))
                                {
                                    if($it['qtde'] >= 0):
                                        continue;
                                    endif;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $it['id']; ?></th>
                                <td><?php echo $it['nome']; ?></td>
                                <td><?php echo $it['fabricante']; ?></td>
                                <td><?php echo $it['qtde']; ?></td>
                                <td><a href="../movimentacao/retirada.php" class="btn btn-outline-danger"> Retirada </a></td>
                            </tr>
                            <?php $_SESSION['idp'] = $it['id']; } ?>
                        </tbody>
                    </table>
                    <a href="../cadastros/cadastrar_produto.php" class="btn btn-outline-primary"> Cadastrar Produto </a>
                    <a href="../movimentacao/entrada.php" class="btn btn-outline-success"> Entrada </a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>