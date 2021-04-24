<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['n']);
        $cpf = mysqli_escape_string($conexao, $_POST['c']);
        $senha = mysqli_escape_string($conexao, $_POST['s']);
        $senha = md5($senha);
        $cargo = mysqli_escape_string($conexao, $_POST['c']);
        $sql = "INSERT INTO usuario(nome, cpf, senha, cargo) VALUES ('$nome', '$cpf', '$senha', '$cargo')";
        $salvar = mysqli_query($conexao, $sql);
        $conferir = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
        $resultado = mysqli_query($conexao, $conferir);
        if(mysqli_num_rows($resultado) == 1):
            $cadastro_realizado = "<script> var cadastro = 'Cadastro realizado com sucesso'; </script>";
            echo $cadastro_realizado;
            echo "<script> alert(cadastro); </script>";
            header('Location: ../geral/pagina_restrita_gerente.php');
        endif;
    endif;
    require_once '../../controladores/verificar_galpao.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="../../css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="../../css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="text-center gradiente">
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
                    <p> Olá <a href="#"> <?php echo $dados['nome']; ?> </a>, <a href="../../controladores/logout.php"> Sair </a></p>
                </div>
            </div>
        </nav>
        <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="h3 mb-3 font-weight-normal"> Cadastro </h1>
            <label for="nome" class="sr-only"> Nome </label>
            <input type="text" name="n" id="nome" class="form-control" placeholder="Nome" required>
            <label for="cpf" class="sr-only"> CPF </label>
            <input type="text" name="c" id="cpf" class="form-control" placeholder="CPF" required>
            <label for="senha" class="sr-only"> Senha </label>
            <input type="password" name="s" id="senha" class="form-control" placeholder="Senha" required>
            <label for="cargo"> Informe o cargo: </label>
            <select class="form-control" name="c" id="cargo">
                <option>  </option>
                <option value="gerente"> Gerente </option>
                <option value="veterinario"> Veterinario </option>
                <option value="funcionario"> Funcionario </option>
            </select>
            <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar </button>
        </form>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>