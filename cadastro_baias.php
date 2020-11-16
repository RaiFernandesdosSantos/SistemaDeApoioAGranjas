<?php
    include_once("conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    if(!isset($_SESSION['logado'])):
        header('Loacation: index.php');
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Pagina inicial </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="gradiente">
<<<<<<< HEAD
        <script src="js/jquery-3.5.1.js"></script>
        <script src="js/bootstrap.js"></script>
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="navbar-brand" href="pagina_restrita_gerente.php"> SWMES </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sistema_engorda.php"> Sistema de engorda </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="sistema_financeiro.php"> Sistema financeiro </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registro.php"> Cadastro de Funcionarios </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cadastro_baias.php"> Galpões </a>
                        </li>
                    </ul>
                    <div class="my-2 my-lg-0">
                        <p> Olá <a href="perfil.php"> <?php echo $dados['nome']; ?></a>, <a href="logout.php"> Sair </a></p>
                    </div>
=======
        <nav class="navbar navbar-expand-md navbar-light bg-light fixed-top"> 
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a class="navbar-brand" href="pagina_restrita_gerente.php"> SWMES </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sistema_engorda.php"> Sistema de engorda </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sistema_financeiro.php"> Sistema financeiro </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registro.php"> Cadastro de Funcionarios </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cadastro_baias.php"> Galpões </a>
                    </li>
                </ul>
                <div class="my-2 my-lg-0">
                    <p> Olá <a href="perfil.php"> <?php echo $dados['nome']; ?></a>, <a href="logout.php"> Sair </a></p>
>>>>>>> b9ad6338094ccbb2e0e4171265bd4014934c9c2e
                </div>
            </nav>
            <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                <div class="sidebar-sticky pt-3">
                    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                        <span>Galpões</span>
                        <a class="d-flex align-items-center text-muted" href="cadastro_galpoes.php" aria-label="Cadastrar Galpão">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        </a>
<<<<<<< HEAD
                    </h6>
                    <?php 
                            $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
                            while($gp = mysqli_fetch_array($galpoes))
                            {
                    ?>
                    <select class="form-control" name="g" id="galpao">
                        <option value="<?php echo $gp['id']; ?>"> <?php echo $gp['identificacao']; ?> </option>
                        <?php 
                            for($baias = $gp['qtde_baias']; $baias != 0; $baias--)
                            {
                                $nome = "Baia".$baias."_".$gp['id'];
                                $id_galpao = $gp['id'];
                                $c_b = "INSERT INTO baia(id_galpao, identificacao, qtde_porcos, capacidade_total_porcos, media_peso) VALUES ('$id_galpao', '$nome', 0, 0, 0)";
                                $cadas_baias = mysqli_query($conexao, $c_b);
                                $sql2 = "SELECT * FROM baia WHERE identificacao = '$nome'";
                                $retorno = mysqli_query($conexao, $sql2);
                                $dados_baia = mysqli_fetch_array($retorno);
                        ?>
                        <option value="<?php echo $dados_baia['id']; ?>"> <?php echo $dados_baia['identificacao'] ?> </option>
                        <?php } ?>
                    </select>
                    <?php } ?>
                </div>
            </nav>
            <div class="col-md-6 col-lg-6">
                <table>
                    
                </table>
=======
                        <ul class="nav flex-column mb-2">
                            <?php 
                                for($baias = $gp['qtde_baias']; $baias != 0; $baias--)
                                {
                                    $nome = "Baia".$baias."_".$gp['id'];
                                    $id_galpao = $gp['id'];
                                    $c_b = "INSERT INTO baia(id_galpao, identificacao, qtde_porcos, capacidade_total_porcos, media_peso) VALUES ('$id_galpao', '$nome', 0, 0, 0)";
                                    $cadas_baias = mysqli_query($conexao, $c_b);
                                    $sql2 = "SELECT * FROM baia WHERE identificacao = '$nome'";
                                    $retorno = mysqli_query($conexao, $sql2);
                                    $dados_baia = mysqli_fetch_array($retorno);
                            ?>
                            <li class="nav-item"> <?php echo $dados_baia['identificacao'] ?> </li>
                            <?php } ?>
                        </ul>
                    </li>
                <?php } ?>
                </ul>
>>>>>>> b9ad6338094ccbb2e0e4171265bd4014934c9c2e
            </div>
        </div>
    </body>
</html>
<<<<<<< HEAD

=======
>>>>>>> b9ad6338094ccbb2e0e4171265bd4014934c9c2e
<?php
    mysqli_close($conexao);
    unset($conexao);
?>