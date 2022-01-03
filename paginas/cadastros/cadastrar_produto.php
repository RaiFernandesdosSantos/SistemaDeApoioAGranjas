<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $nome = mysqli_escape_string($conexao, $_POST['nome']);
        $fornecedor = mysqli_escape_string($conexao, $_POST['forne']);
        $unidade = mysqli_escape_string($conexao, $_POST['unidade']);
        $tipo = mysqli_escape_string($conexao, $_POST['tipo'])
        $sql = "INSERT INTO item(nome, fornecedor, unidade, qtde, tipo) VALUES ('$nome', '$fornecedor', '$unidade', '$tipo', 0)";
        $salvar = mysqli_query($conexao, $sql);
        header('Location: ../geral/estoque.php');
    endif;
    require_once '../../controladores/verificar_cargo.php';
?>

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
                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Produtos </h1>
                        <label for="n" class="sr-only"> Nome </label>
                        <input type="text" name="nome" id="n" class="form-control" placeholder="Nome" required>
                        <?php 
                            $fornecedor = mysqli_query($conexao, "SELECT * FROM fornecedor");
                            while($forn = mysqli_fetch_array($fornecedor))
                            {
                        ?>
                        <label for="f" class="sr-only"> <?php echo $forn['fantasia']; ?> </label>
                        <select class="form-control" name="forne" id="f">
                            <option values=""> Selecione </option>
                            <option value="<?php echo $forn['id']; ?>"> <?php echo $forn['fantasia']; ?> </option>
                        </select>
                        <?php } ?>
                        <label for="u"> Informe a medida do produto: </label>
                        <select class="form-control" name="unidade" id="u">
                            <option value=""> Selecione </option>
                            <option value="Kg"> Quilogramas </option>
                            <option value="Ml"> Mililitros </option>
                            <option value="G"> Gramas </option>
                            <option value="L"> Litros </option>
                            <option value="U"> Unidade </option>
                        </select>
                        <label for="t"> Informe o tipo do produto </label>
                        <select class="form-control" name="tipo" id="t">
                            <option value=""> Selecione </option>
                            <option value="1"> Ração </option>
                            <option value="2"> Vacina </option>
                            <option value="3"> Outros </option>
                        </select>
                        <div class="btn-group">
                            <button class="btn btn-lg btn-outline-success" type="submit" name="btn-submit"> Cadastrar Produto </button>
                            <a class="btn btn-lg btn-outline-primary" href="../geral/estoque.php"> Voltar </a>
                        </div>
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