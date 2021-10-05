<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
    if(isset($_POST['btn-submit'])):
        header('Location: impressao.php');
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Lista de Baias e Galpões </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <script src="js/jquery-3.5.1.js"></script>
        <script src="js/bootstrap.js"></script>
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <form class="form-signin" method="POST" action="impressao.php">
                        <label for="b"> Data Inicial:  </label>
                        <input type="date" id="b" name="inicial" class="form-control" required>
                        <label for="e"> Data Final:  </label>
                        <input type="date" id="e" name="final" class="form-control" required>
                        <h5> Comparar com o periodo: </h5>
                        <label for="bp"> Data Inicial:  </label>
                        <input type="date" id="bp" name="inicialp" class="form-control" required>
                        <label for="ep"> Data Final:  </label>
                        <input type="date" id="ep" name="finalp" class="form-control" required>
                        <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-submit"> Ver Relatorio </button>
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