<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_galpao.php';
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
            <?php include '../../includes/barra_superior_gerente.php'; ?>
            <div class="row">
                <?php include '../../includes/barra_lateral_gerente.php'; ?>
                <?php include '../../includes/mensagem.php'; ?>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>