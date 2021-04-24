<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $baias = mysqli_escape_string($conexao, $_POST['qb']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);
        $sql = "INSERT INTO galpao(identificacao, qtde_baias, funcao, total_porcos) VALUES ('$identificacao', '$baias', '$funcao', 0)";
        $salvar = mysqli_query($conexao, $sql);
        $conferir = "SELECT identificacao FROM galpao WHERE identificacao = '$identificacao'";
        $resultado = mysqli_query($conexao, $conferir);
        if(mysqli_num_rows($resultado) == 1):
            $cadastro_realizado = "<script> var cadastro = 'Cadastro realizado com sucesso'; </script>";
            echo $cadastro_realizado;
            echo "<script> alert(cadastro); </script>";
        endif;
    endif;
    require_once '../../controladores/verificar_galpao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../../css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="gradiente">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="navbar-brand" href="../geral/pagina_restrita_gerente.php"> SWMES </a>
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
                        <p> Olá <a href="#"> <?php echo $dados['nome']; ?></a>, <a href="../../controladores/logout.php"> Sair </a></p>
                    </div>
                </div>
            </nav>
            <div class=" offset-md-2 offset-lg-2 col-md-8 col-lg-8 bg-light">
                <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Galpões </h1>
                    <label for="identificacao" class="sr-only"> Identificação </label>
                    <input type="text" name="i" id="identificacao" class="form-control" placeholder="Identificação" required>
                    <label for="baias" class="sr-only"> Quantidade de Baias </label>
                    <input type="text" name="qb" id="baias" class="form-control" placeholder="Quantidade de Baias" required>
                    <label for="funcao"> Informe a função desse galpão: </label>
                    <select class="form-control" name="f" id="funcao">
                        <option value=""> Selecione </option>
                        <option value="Maternidade"> Maternidade </option>
                        <option value="Creche"> Creche </option>
                        <option value="Terminacao"> Terminação </option>
                        <option value="Quarentena"> Quarentena </option>
                    </select>
                    <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar-se </button>
                </form>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>