<?php
    include_once("conexao_bd.php");
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
            header('Location: pagina_restrita_gerente.php');
        endif;
        mysqli_close($conexao);
        unset($conexao);
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="text-center gradiente">
        <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="h3 mb-3 font-weight-normal"> Cadastre-se </h1>
            <label for="nome" class="sr-only"> Nome </label>
            <input type="text" name="n" id="nome" class="form-control" placeholder="Nome" required>
            <label for="cpf" class="sr-only"> CPF </label>
            <input type="text" name="c" id="cpf" class="form-control" placeholder="CPF" required>
            <label for="senha" class="sr-only"> Senha </label>
            <input type="password" name="s" id="senha" class="form-control" placeholder="Senha" required>
            <label for="cargo"> Informe seu cargo: </label>
            <select class="form-control" name="c" id="cargo">
                <option>  </option>
                <option value="gerente"> Gerente </option>
                <option value="veterinario"> Veterinario </option>
                <option value="funcionario"> Funcionario </option>
            </select>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-submit"> Cadastrar-se </button>
        </form>
    </body>
</html>