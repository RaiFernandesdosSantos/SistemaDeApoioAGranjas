<?php
    include_once ("conexao_bd.php");
    session_start();
    if(isset($_POST['btn-entrar'])):
        $erros = array();
        $cpf = mysqli_escape_string($conexao, $_POST['cpf']);
        $senha = mysqli_escape_string($conexao, $_POST['senha']);
        $sql = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
        $resultado = mysqli_query($conexao, $sql);
        if(mysqli_num_rows($resultado) > 0):
            $senha = md5($senha);
            $sql = "SELECT * FROM usuario WHERE cpf = '$cpf' AND senha = '$senha'";
            $resultado = mysqli_query($conexao, $sql);
            if(mysqli_num_rows($resultado) == 1):
                $dados = mysqli_fetch_array($resultado);
                mysqli_close($conexao);
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                header('Location: pagina_restrita_gerente.php');
            else:
                $erros[] = "<li> Usuário e senha não conferem </li>";
            endif;
        else:
            $erros[] = "<li> Usuário inexistente <li>";
        endif;
    endif;
?>

<!DOCTYPE html>
<html lang="pt-br">
    <head>
		<meta charset = "UTF-8">
		<title> Login </title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/estilo.css" rel="stylesheet" media="screen">
	</head>
    <body class="text-center gradiente">
        <?php
            if(!empty($erros)):
                foreach($erros as $erros):
                    echo $erros;
                endforeach;
            endif;
        ?>
        <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="h3 mb-3 font-weight-normal"> Login </h1>
            <label for="inputCPF" class="sr-only"> CPF </label>
            <input type="text" id="inputCPF" class="form-control" placeholder="CPF" name="cpf" required>
            <label for="inputPassword" class="sr-only"> Senha </label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
			<p> Se não tem uma conta,<a href="registro.php"> clique aqui </a></p>
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-entrar"> Login </button>
        </form>
    </body>
</html>