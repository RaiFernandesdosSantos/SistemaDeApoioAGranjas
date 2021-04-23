<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $nome_bd = "sistema_web";
    $conexao = mysqli_connect($servername, $username, $password, $nome_bd);
    if($conexao -> connect_error)
    {
        die("Falha na conexao: " .$conexao -> connect_error);
        include_once("criar_bd.php");
    }
    $sucesso = "<script> var sucesso = 'Banco de dados conectado com sucesso'; </script>";
    echo $sucesso;
    echo "<script> alert(sucesso); </script>";
?>