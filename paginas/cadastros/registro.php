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
    endif;
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro de Funcionários </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="text-center gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Funcionários </h1>
                        <label for="nome" class="sr-only"> Nome </label>
                        <input type="text" name="n" id="nome" class="form-control" placeholder="Nome" required>
                        <label for="cpf" class="sr-only"> CPF </label>
                        <input type="text" name="c" id="cpf" class="form-control" placeholder="CPF" required>
                        <label for="senha" class="sr-only"> Senha </label>
                        <input type="password" name="s" id="senha" class="form-control" placeholder="Senha" required>
                        <label for="cargo"> Informe o cargo: </label>
                        <select class="form-control" name="c" id="cargo">
                            <option>  </option>
                            <option value="1"> Gerente </option>
                            <option value="2"> Veterinario </option>
                            <option value="3"> Funcionário </option>
                        </select>
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar Funcionário </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>