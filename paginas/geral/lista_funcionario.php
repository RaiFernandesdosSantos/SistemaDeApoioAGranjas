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
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light pre-scrollable">
                    <h4 class="text-muted"> Funcionarios </h4>

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
                                    if($us['cargo'] == 1):
                                        $cargo = "Gerente";
                                    elseif($us['cargo'] == 2):
                                        $cargo = "Veterinario";
                                    elseif($us['cargo'] == 3):
                                        $cargo = "Funcionário";
                                    endif;
                            ?>

                            <tr>
                                <th scope="row"><?php echo $us['id']; ?></th>
                                <td><?php echo $us['nome']; ?></td>
                                <td><?php echo $cargo; ?></td>
                                <td> 
                                    <a href="../../controladores/deletar_funcionario.php?id=<?php echo $us['id']; ?>" 
                                    class="btn btn-sm btn-warning"> Excluir Funcionario </a>
                                </td>
                            </tr>
                            
                            <?php } ?>
                            
                            <!-- -->

                        </tbody>
                    </table>

                    <!-- -->
                    
                </div>
                <div class=" offset-md-3 offset-lg-3 col-md-9 col-lg-9 bg-light">
                    <a href="../cadastros/registro.php" class="btn btn-outline-success"> Cadastrar Funcionario </a>
                    <a href="../geral/pagina_restrita_gerente.php" class="btn btn-outline-primary"> Voltar </a>            
                </div>
            </div>
        </div>
    </body>
</html>

<?php
    mysqli_close($conexao);
    unset($conexao);
?>