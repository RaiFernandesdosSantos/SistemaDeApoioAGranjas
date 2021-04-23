<?php
    include '../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $idp = mysqli_escape_string($conexao, $_POST['produtos']);
        $qtde = mysqli_escape_string($conexao, $_POST['qtde']);
        $sql = "INSERT INTO estoque(id_produto, qtde, data_hora, id_usuario, retirada) VALUES ('$idp', '$qtde', now(), '$id', 0)";
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
        header('Loacation: estoque.php');
    endif;
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
        <div class="container">
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
                <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h1 class="h3 mb-3 font-weight-normal"> Entrada de Estoque </h1>
                    <label for="item"> Produtos: </label>
                    <select class="form-control" name="produtos" id="item">
                        <option values=""> Selecione </option>
                        <?php 
                            $item = mysqli_query($conexao, "SELECT * FROM item");
                            while($it = mysqli_fetch_array($item))
                            {
                        ?>
                        <option value="<?php echo $it['id']; ?>"> <?php echo $it['nome'] ?> </option>
                        <?php } ?>
                    </select>
                    <label for="q" class="sr-only"> Quantidade: </label>
                    <input type="text" name="qtde" id="q" class="form-control" placeholder="Quantidade" required>
                    <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Dar entrada </button>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>