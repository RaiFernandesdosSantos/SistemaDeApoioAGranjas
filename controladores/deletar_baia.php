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

    $idb = $_GET['id'];
    $sql = "SELECT * FROM baia WHERE id = '$idb'";
    $rs = mysqli_query($conexao, $sql);
    $db = mysqli_fetch_array($rs);

    $id_galpao = $db['id_galpao'];
    $sql = "SELECT * FROM galpao WHERE id = '$id_galpao'";
    $rs = mysqli_query($conexao, $sql);
    $dg = mysqli_fetch_array($rs);

    $sql = "SELECT * FROM historico_baia WHERE id_baia = '$idb' AND data_hora = (SELECT max(data_hora) FROM historico_baia WHERE 
    id_baia = '$idb') AND retirada = 0";
    $rs = mysqli_query($conexao, $sql);
    $hb = mysqli_fetch_array($rs);

    $menos_baia = $dg['qtde_baias'] - 1;
    $menos_porcos = $dg['total_porcos'] - $hb['qtde_porcos'];

    if($idb != 0):
        $deletar = "DELETE FROM historico_baia WHERE id = '$idb'";
        $salvar = mysqli_query($conexao, $deletar);

        $deletar = "DELETE FROM historico_itens_baia WHERE id = '$idb'";
        $salvar = mysqli_query($conexao, $deletar);

        $atualiza = "UPDATE galpao SET qtde_baias = '$menos_baia', total_porcos = '$menos_porcos' WHERE id = '$id_galpao'";
        $salvar = mysqli_query($conexao, $atualiza);

        $deletar = "DELETE FROM baia WHERE id = '$idb'";
        $salvar = mysqli_query($conexao, $deletar);

        //header('Location: ../paginas/geral/lista_baia_galpao.php');
    endif;
?>