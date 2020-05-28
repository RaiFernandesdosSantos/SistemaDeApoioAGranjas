<?php
    include_once("conexao_bd.php");
    include_once("criar_bd.php");
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $senha = md5($senha);
    $cargo = $_POST['cargo'];
    $sql = "INSERT INTO usuario(nome, cpf, email, senha, cargo) VALUES ('$nome', '$cpf', '$email', '$senha', '$cargo')";
    $salvar = mysqli_query($conexao, $sql);
    $sql1 = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
    $resultado = mysqli_query($conexao, $sql1);
    if(mysqli_num_rows($resultado) == 1):
        $cadastro_realizado = "<script> var cadastro = 'Cadastro realizado com sucesso'; </script>";
        echo $cadastro_realizado;
        echo "<script> alert(cadastro); </script>";
        header('Location: index.php');
    endif;
    mysqli_close($conexao);
    unset($conexao);
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
            <label for="inputNome" class="sr-only"> Nome </label>
            <input type = "text" name="nome" id="inputNome" class="form-control" placeholder="Nome" required>
            <label for="inputCPF" class="sr-only"> CPF </label>
            <input type="text" name="cpf" id="inputCPF" class="form-control" placeholder="CPF" required>
            <label for="inputEmail" class="sr-only"> E-mail </label>
            <input type="email" name="email" id="inputEmail" class="form-control" placeholder="E-mail">
            <label for="inputPassword" class="sr-only"> Senha </label>
            <input type="password" name="senha" id="inputPassword" class="form-control" placeholder="Senha" required>
            <label for="cargos"> Informe seu cargo: </label>
            <select class="form-control" name="cargo" id="cargos">
                <option>  </option>
                <option value="gerente"> Gerente </option>
                <option value="veterinario"> Veterinario </option>
                <option value="funcionario"> Funcionario </option>
            </select>
            <p> Se ja tiver uma conta,<a href="index.php"> clique aqui </a></p>
            <button class="btn btn-lg btn-primary btn-block" type="submit"> Cadastrar-se </button>
        </form>
        <script> alert(mensagem); </script>
    </body>
</html>