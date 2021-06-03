<?php
    include_once("conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    if(!isset($_SESSION['logado'])):
        header('Loacation: ../../index.php');
    endif;
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
                $dados = mysqli_fetch_array($r1);
                $id = $dados['id'];
                $_SESSION['dg'] = $id;
                header('Location: ../paginas/geral/dados_galpao.php');
                break;
            elseif(mysqli_num_rows($r2) == 1):
                $dados = mysqli_fetch_array($r2);
                $id = $dados['id'];
                $_SESSION['db'] = $id;
                header('Location: ../paginas/geral/dados_baia.php');
                break;
            else:
                header('Location: ../paginas/geral/lista_baia_galpao.php');
            endif;
        endif;
    }
?>