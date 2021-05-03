<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['nome']);
        $fabricante = mysqli_escape_string($conexao, $_POST['fabricante']);
        $unidade = mysqli_escape_string($conexao, $_POST['unidade']);
        $sql = "INSERT INTO item(nome, fabricante, unidade, qtde) VALUES ('$nome', '$fabricante', '$unidade', 0)";
        $salvar = mysqli_query($conexao, $sql);
    endif;
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Produtos </h1>
                        <label for="n" class="sr-only"> Nome </label>
                        <input type="text" name="nome" id="n" class="form-control" placeholder="Nome" required>
                        <label for="f" class="sr-only"> Fabricante </label>
                        <input type="text" name="fabricante" id="f" class="form-control" placeholder="Fabricante" required>
                        <label for="u"> Informe a unidade do produto: </label>
                        <select class="form-control" name="unidade" id="u">
                            <option value=""> Selecione </option>
                            <option value="Kg"> Quilogramas </option>
                            <option value="Ml"> Mililitros </option>
                            <option value="G"> Gramas </option>
                            <option value="L"> Litros </option>
                        </select>
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar-se </button>
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