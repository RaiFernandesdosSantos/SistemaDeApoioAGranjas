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

    $idg = $_GET['id'];
    if($idg != 0):
        $selBaia = "SELECT * FROM baia WHERE id_galpao = '$idg'";
        $rs = mysqli_query($conexao, $selBaia);

        while($baias = mysqli_fetch_array($rs))
        {
            $idb = $baias['id'];
            $delHist = "DELETE FROM historico_baia WHERE id_baia = '$idb'";
            $salvar = mysqli_query($conexao, $delHist);
        }

        $deletar_baia = "DELETE FROM baia WHERE id_galpao = '$idg'";
        $salvar = mysqli_query($conexao, $deletar_baia);

        $deletar = "DELETE FROM galpao WHERE id = '$idg'";
        $salvar = mysqli_query($conexao, $deletar);

        header('Location: ../paginas/geral/lista_baia_galpao.php');
    endif;
?>