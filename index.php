<?php
    include_once("conexao_bd.php");
    session_start();
    if(isset($_POST['btn-entrar'])):
        $cpf = mysqli_escape_string($conexao, $_POST['cpf']);
        $senha = mysqli_escape_string($conexao, $_POST['senha']);
        $cargo1 = "gerente";
        $cargo2 = "veterinario";
        $cargo3 = "funcionario";
        $sql = "SELECT cpf FROM usuario WHERE cpf = '$cpf'";
        $resultado = mysqli_query($conexao, $sql);
        if(mysqli_num_rows($resultado) > 0):
            $senha = md5($senha);
            $sql = "SELECT * FROM usuario WHERE cpf = '$cpf' AND senha = '$senha'";
            $resultado = mysqli_query($conexao, $sql);
            if(mysqli_num_rows($resultado) == 1):
                $dados = mysqli_fetch_array($resultado);
                $_SESSION['logado'] = true;
                $_SESSION['id_usuario'] = $dados['id'];
                $sql1 = "SELECT * FROM usuario WHERE cpf = '$cpf' and senha = '$senha' and cargo = '$cargo1'";
                $resultado1 = mysqli_query($conexao, $sql1);
                $sql2 = "SELECT * FROM usuario WHERE cpf = '$cpf' and senha = '$senha' and cargo = '$cargo2'";
                $resultado2 = mysqli_query($conexao, $sql2);
                $sql3 = "SELECT * FROM usuario WHERE cpf = '$cpf' and senha = '$senha' and cargo = '$cargo3'";
                $resultado3 = mysqli_query($conexao, $sql3);
                if(mysqli_num_rows($resultado1) == 1):
                    header('Location: pagina_restrita_gerente.php');
                elseif(mysqli_num_rows($resultado2) == 1):
                    header('Location: pagina_restrita_veterinario.php');
                elseif(mysqli_num_rows($resultado3) == 1):
                    header('Location: pagina_restrita_funcionario.php');
                endif;
                mysqli_close($conexao);
                unset($conexao);
            else:
                $erro1 = "<script> var erro1 = 'Usuário e senha não conferem'; </script>";
                echo $erro1;
                echo "<script> alert(erro1); </script>";
            endif;
        else:
            $erro2 = "<script> var erro2 = 'Usuário inexistente'; </script>";
            echo $erro2;
            echo "<script> alert(erro2); </script>";
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
        <form class="form-signin" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <h1 class="h3 mb-3 font-weight-normal"> Login </h1>
            <label for="inputCPF" class="sr-only"> CPF </label>
            <input type="text" id="inputCPF" class="form-control" placeholder="CPF" name="cpf" required>
            <label for="inputPassword" class="sr-only"> Senha </label>
			<input type="password" id="inputPassword" class="form-control" placeholder="Senha" name="senha" required>
            <a href="#"> Esqueceu a senha? </a>
            <button class="btn btn-lg btn-outline-primary btn-block" type="submit" name="btn-entrar"> Login </button>
        </form>
    </body>
</html>