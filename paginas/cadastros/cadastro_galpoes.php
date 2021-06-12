<?php
    include '../../controladores/autenticacao_usuario.php';
    if(isset($_POST['btn-submit'])):
        $identificacao = mysqli_escape_string($conexao, $_POST['i']);
        $baias = mysqli_escape_string($conexao, $_POST['qb']);
        $funcao = mysqli_escape_string($conexao, $_POST['f']);
        $sql = "INSERT INTO galpao(identificacao, qtde_baias, funcao, total_porcos) VALUES ('$identificacao', '$baias', '$funcao', 0)";
        $salvar = mysqli_query($conexao, $sql);
        header('Location: ../geral/pagina_restrita_gerente.php');
    endif;
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Cadastro de Galpões </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <h1 class="h3 mb-3 font-weight-normal"> Cadastro de Galpões </h1>
                        <label for="identificacao" class="sr-only"> Identificação </label>
                        <input type="text" name="i" id="identificacao" class="form-control" placeholder="Identificação" required>
                        <label for="baias" class="sr-only"> Quantidade de Baias </label>
                        <input type="text" name="qb" id="baias" class="form-control" placeholder="Quantidade de Baias" required>
                        <label for="funcao"> Informe a função desse galpão: </label>
                        <select class="form-control" name="f" id="funcao">
                            <option value=""> Selecione </option>
                            <option value="1"> Maternidade </option>
                            <option value="2"> Creche </option>
                            <option value="3"> Terminação </option>
                            <option value="4"> Quarentena </option>
                        </select>
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Cadastrar Galpão </button>
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