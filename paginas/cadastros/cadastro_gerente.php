<?php
    include_once("../../controladores/conexao_bd.php");
    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['n']);
        $cpf = mysqli_escape_string($conexao, $_POST['c']);
        $senha = mysqli_escape_string($conexao, $_POST['s']);
        $senha = md5($senha);
        $sql = "INSERT INTO usuario(nome, cpf, senha, cargo) VALUES ('$nome', '$cpf', '$senha', 1)";
        $salvar = mysqli_query($conexao, $sql);
        $conferir = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
        $resultado = mysqli_query($conexao, $conferir);
        if(mysqli_num_rows($resultado) == 1):
            $cadastro_realizado = "<script> var cadastro = 'Cadastro realizado com sucesso'; </script>";
            echo $cadastro_realizado;
            echo "<script> alert(cadastro); </script>";
            header('Location: ../../index.php');
        endif;
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="text-center gradiente">
        <div class="container">
            <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <h1 class="h3 mb-3 font-weight-normal"> Cadastro </h1>
                <label for="nome" class="sr-only"> Nome </label>
                <input type="text" name="n" id="nome" class="form-control" placeholder="Nome" required>
                <label for="cpf" class="sr-only"> CPF </label>
                <input type="text" name="c" id="cpf" class="form-control" placeholder="CPF" required>
                <label for="senha" class="sr-only"> Senha </label>
                <input type="password" name="s" id="senha" class="form-control" placeholder="Senha" required>
                <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Cadastrar </button>
                <a href="../../index.php" class="btn btn-outline-primary btn-block"> Voltar </a>
            </form>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>