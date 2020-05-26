<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $nome_bd = "sistema_web";
    $conexao = mysqli_connect($servername, $username, $password);
    $sql = "SHOW DATABASES LIKE '".$nome_bd."'";
    $resultado = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($resultado) == 1):
        $conexao = mysqli_connect($servername, $username, $password, $nome_bd);
    else:
        $sql1 = "CREATE DATABASE '$nome_bd'";
        $criar_bd = mysqli_query($conexao, $sql1);
        $conexao = mysqli_connect($servername, $username, $password, $nome_bd);
    endif;
?>