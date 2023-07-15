<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
    
    //Script para cadastro de fornecedores no Banco de Dados

    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['rz']);
        $fantasia = mysqli_escape_string($conexao, $_POST['f']);
        $cnpj = mysqli_escape_string($conexao, $_POST['c']);
        $rep = mysqli_escape_string($conexao, $_POST['ve']);
        $tel = mysqli_escape_string($conexap, $_POST['t']);
        $email = mysqli_escape_string($conexao, $_POST['e']);
        $endereco = mysqli_escape_string($conexao, $_POST['en']);
        $vendedor = mysqli_escape_string($conexao, $_POST['ve']);

        $sql = "INSERT INTO fornecedor(razao_social, fantasia, cnpj, telefone, email, endereco, vendedor) 
        VALUES ('$nome', '$fantasia','$cnpj', '$rep', '$tel', '$email', '$endereco', '$vendedor')";
        $salvar = mysqli_query($conexao, $sql);

        header('Location: ../geral/estoque.php');
    endif;

    // ?>

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
                    
                    <!-- Formulario para cadastro de Fornecedores -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Fornecedores </h1>

                        <label for="razao" class="sr-only"> Razão Social </label>
                        <input type="text" name="rz" id="razao" class="form-control" placeholder="Razão Social" required>
                        
                        <label for="fantasia" class="sr-only"> Nome Fantasia </label>
                        <input type="text" name="f" id="fantasia" class="form-control" placeholder="Nome Fantasia" required>

                        <label for="cnpj" class="sr-only"> CNPJ </label>
                        <input type="text" name="c" id="cnpj" class="form-control" placeholder="CNPJ" required>

                        <label for="tel" class="sr-only"> Telefone </label>
                        <input type="text" name="t" id="tel" class="form-control" placeholder="Telefone" required>

                        <label for="email" class="sr-only"> E-mail </label>
                        <input type="text" name="e" id="email" class="form-control" placeholder="E-mail" required>

                        <label for="ender" class="sr-only"> Endereço </label>
                        <input type="text" name="en" id="ender" class="form-control" placeholder="Endereço" required>

                        <label for="vend" class="sr-only"> Vendedor ou Responsável </label>
                        <input type="text" name="ve" id="vend" class="form-control" placeholder="Vendedor ou Responsável" required>
                        
                        <button class="btn btn-outline-success btn-block" type="submit" name="btn-submit"> Cadastrar Fornecedor </button>
                        <a class="btn btn-outline-primary btn-block" href="../geral/pagina_restrita_gerente.php"> Voltar </a>
                    </form>

                    <!-- -->

                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>