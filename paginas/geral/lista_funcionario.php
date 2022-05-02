<?php
    include '../../controladores/autenticacao_usuario.php';
    require_once '../../controladores/verificar_cargo.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Estoque </title>
		<?php include '../../includes/head.php'; ?>
	</head>
    <body class="gradiente">
        <div class="container">
            <?php include $bs; ?>
            <div class="row">
                <?php include $bl; ?>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <h4 class="text-muted"> Estoque </h4>

                    <!-- Tabela com todos os funcionario cadastrados no Banco de Dados -->

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col"> # </th>
                                <th scope="col"> Nome </th>
                                <th scope="col"> Cargo </th>
                                <th scope="col"> Ações </th>
                            </tr>
                        </thead>
                        <tbody>

                            <!-- Script para buscar todos os cadastrados e os imprimir na tela -->

                            <?php 
                                $user = mysqli_query($conexao, "SELECT * FROM usuario");
                                while($us = mysqli_fetch_array($user))
                                {
                            ?>

                            <tr>
                                <th scope="row"><?php echo $us['id']; ?></th>
                                <td><?php echo $us['nome']; ?></td>
                                <td><?php echo $us['cargo']; ?></td>
                                <td><button class="btn btn-outline-primary btn-block" type="submit" name="btn-submit"> 
                                    Excluir Funcionario </button></td>
                            </tr>
                            
                            <?php } ?>
                            
                            <!-- -->

                        </tbody>
                    </table>

                    <!-- -->

                    <a href="../cadastros/registro.php" class="btn btn-outline-primary"> Cadastrar Funcionario </a>
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>