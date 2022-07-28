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

    $idIt = $_GET['id'];

    if($idIt != 0):
        $deletar = "DELETE FROM estoque WHERE id_produto = '$idIt'";
        $salvar = mysqli_query($conexao, $deletar);

        $deletar = "DELETE FROM historico_itens_baia WHERE id_item = '$idIt'";
        $salvar = mysqli_query($conexao, $deletar);

        $deletar = "DELETE FROM item WHERE id = '$idIt'";
        $salvar = mysqli_query($conexao, $deletar);

        header('Location: ../paginas/geral/estoque.php');
    endif;

?>