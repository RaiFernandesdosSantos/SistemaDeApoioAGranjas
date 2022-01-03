<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['n']);
        $cnpj = mysqli_escape_string($conexao, $_POST['c']);
        $rep = mysqli_escape_string($conexao, $_POST['r']);
        $tel = mysqli_escape_string($conexap, $_POST['t']);
        $email = mysqli_escape_string($conexao, $_POST['e']);
        $endereco = mysqli_escape_string($conexao, $_POST['en']);
        $sql = "INSERT INTO fornecedor(razao_social, fantasia, cnpj, telefone, email, endereco) 
        VALUES ('$nome', '$cnpj', '$rep', '$tel', '$email', '$endereco')";
        $salvar = mysqli_query($conexao, $sql);
        header('Location: ../geral/estoque.php');
    endif;
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro de Fornecedor </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="text-center gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Fornecedores </h1>
                        <label for="nome" class="sr-only"> Nome da Empresa </label>
                        <input type="text" name="n" id="nome" class="form-control" placeholder="Nome da Empresa" required>
                        <label for="cnpj" class="sr-only"> CNPJ </label>
                        <input type="text" name="c" id="cnpj" class="form-control" placeholder="CNPJ" required>
                        <label for="rep" class="sr-only"> Nome do Representante </label>
                        <input type="text" name="r" id="rep" class="form-control" placeholder="Nome do Representante" required>
                        <label for="tel" class="sr-only"> Telefone </label>
                        <input type="text" name="t" id="tel" class="form-control" placeholder="Telefone" required>
                        <label for="email" class="sr-only"> E-mail </label>
                        <input type="text" name="e" id="email" class="form-control" placeholder="E-mail" required>
                        <label for="ender" class="sr-only"> Endereço </label>
                        <input type="text" name="en" id="ender" class="form-control" placeholder="Endereço" required>
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