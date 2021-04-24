<?php
    include 'autenticacao_usuario.php';
    $galpoes = mysqli_query($conexao, "SELECT * FROM galpao");
    while($gp = mysqli_fetch_array($galpoes))
    {
        if(isset($_POST['btn-dados'])):
            $nome = "g".$gp['id'];
            $opcao = mysqli_escape_string($conexao, $_POST[$nome]);
            $sql = "SELECT * FROM galpao WHERE identificacao = '$opcao'";
            $r1 = mysqli_query($conexao, $sql);
            $sql = "SELECT * FROM baia WHERE identificacao = '$opcao'";
            $r2 = mysqli_query($conexao, $sql);
            if(mysqli_num_rows($r1) == 1):
                $_SESSION['dg'] = $opcao;
                header('Location: ../paginas/geral/dados_galpao.php');
                break;
            elseif(mysqli_num_rows($r2) == 1):
                $_SESSION['db'] = $opcao;
                header('Location: ../paginas/geral/dados_baia.php');
                break;
            else:
                header('Location: ../paginas/geral/lista_baia_galpao.php');
            endif;
        endif;
    }
?>