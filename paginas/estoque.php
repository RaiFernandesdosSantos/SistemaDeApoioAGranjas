<?php
    include '../controladores/autenticacao_usuario.php';
    unset($_SESSION['idp']);
    require_once '../controladores/verificar_galpao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="gradiente">
        <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="pagina_restrita_gerente.php"> SWMES </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Sistema de engorda </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php"> Cadastro de Funcionarios </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo $pagina; ?>"> Galpões </a>
                    </li>
                </ul>
                <div class="my-2 my-lg-0">
                    <p> Olá <a href="#"> <?php echo $dados['nome']; ?> </a>, <a href="../controladores/logout.php"> Sair </a></p>
                </div>
            </div>
        </nav>
        <div class=" offset-md-2 offset-lg-2 col-md-8 col-lg-8 bg-light">
            <h4 class=" text-muted"> Estoque </h4>
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
                    ?>
                    <tr>
                        <th scope="row"><?php echo $it['id']; ?></th>
                        <td><?php echo $it['nome']; ?></td>
                        <td><?php echo $it['fabricante']; ?></td>
                        <td><?php echo $it['qtde']; ?></td>
                        <td><a href="retirada.php" class="btn btn-outline-danger"> Retirada </a></td>
                    </tr>
                    <?php $_SESSION['idp'] = $it['id']; ?>
                    <?php } ?>
                </tbody>
            </table>
            <a href="cadastrar_produto.php" class="btn btn-outline-primary"> Cadastrar Produto </a>
            <a href="entrada.php" class="btn btn-outline-success"> Entrada </a>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>