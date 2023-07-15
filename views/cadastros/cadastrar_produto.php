<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
    
    //Script para inserir produtos no Banco de Dados

    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['nome']);
        $fabricante = mysqli_escape_string($conexao, $_POST['fabri']);
        $unidade = mysqli_escape_string($conexao, $_POST['unidade']);
        $tipo = mysqli_escape_string($conexao, $_POST['tipo']);

        $sql = "INSERT INTO item(nome, unidade, fabricante, tipo) VALUES ('$nome', '$unidade', '$fabricante', '$tipo')";
        $salvar = mysqli_query($conexao, $sql);
        
        header('Location: ../geral/estoque.php');
    endif;
    
    // ?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro de Produtos </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    
                    <!-- Formulario para o cadastro de produtos -->

                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Produtos </h1>

                        <label for="n" class="sr-only"> Nome </label>
                        <input type="text" name="nome" id="n" class="form-control" placeholder="Nome" required>

                        <label for="fa" class="sr-only"> Fabricante </label>
                        <input type="text" name="fabri" id="fa" class="form-control" placeholder="Fabricante" required>

                        <!-- Select com as unidades de medidas para os produtos -->

                        <label for="u"> Informe a medida do produto: </label>
                        <select class="form-control" name="unidade" id="u">
                            <option value=""> Selecione </option>
                            <option value="Kg"> Quilogramas </option>
                            <option value="L"> Litros </option>
                            <option value="Un"> Unidade </option>
                        </select>
                        
                        <!-- -->
                        <!-- Select com os tipos de produtos -->

                        <label for="t"> Informe o tipo do produto </label>
                        <select class="form-control" name="tipo" id="t">
                            <option value=""> Selecione </option>
                            <option value="1"> Ração </option>
                            <option value="2"> Vacina </option>
                            <option value="3"> Outros </option>
                        </select>
                        
                        <!-- -->

                        <button class="btn btn-md btn-outline-success btn-block" type="submit" name="btn-submit"> Cadastrar Produto </button>
                        <a class="btn btn-md btn-outline-primary btn-block" href="../geral/estoque.php"> Voltar </a>
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