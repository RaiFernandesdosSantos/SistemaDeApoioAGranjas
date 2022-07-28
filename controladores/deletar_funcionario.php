<?php
    include_once("conexao_bd.php");

    //Autenticação do úsuario

    session_start();

    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";

    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);

    if(!isset($_SESSION['logado'])):
        header('Loacation: ../../index.php');
    endif;

    //

    $idus = $_GET['id'];
    if($idus != 0):
        $mudaHist = "UPDATE historico_baia SET id_usuario = 1 WHERE id = '$idus'";
        $salvar = mysqli_query($conexao, $mudaHist);

        $sql = "UPDATE estoque SET id_usuario = 1 WHERE id = '$idus'";
        $salvar = mysqli_query($conexao, $sql);

        $sql = "UPDATE historico_itens_baia SET id_usuario = 1 WHERE id = '$idus'";
        $salvar = mysqli_query($conexao, $sql);

        $deletar = "DELETE FROM usuario WHERE id = '$idus'";
        $salvar = mysqli_query($conexao, $deletar);

        //header('Location: ../paginas/geral/lista_funcionario.php');
    else:
        header('Location: ../paginas/geral/lista_funcionario.php');
    endif;
?>