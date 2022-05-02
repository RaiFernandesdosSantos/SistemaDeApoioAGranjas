<?php

    //Pesquisa no Banco de Dados para verificar se é um úsuario cadastrado

    include_once("../../controladores/conexao_bd.php");
    session_start();
    $id = $_SESSION['id_usuario'];
    $sql = "SELECT * FROM usuario WHERE id = '$id'";
    $resultado = mysqli_query($conexao, $sql);
    $dados = mysqli_fetch_array($resultado);
    if(!isset($_SESSION['logado'])):
        header('Location: ../../index.php');
    endif;

    //

?>