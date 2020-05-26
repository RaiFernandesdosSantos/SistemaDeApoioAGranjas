<?php
    include_once("conexao_bd.php");
    $tabela = "usuario";
    $sql = "SHOW TABLES LIKE '".$tabela."'";
    $resultado = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($resultado) == 1):
        mysqli_close($conexao);
    else:
        $sql1 = "CREATE TABLE usuario(id int NOT NULL AUTO_INCREMENT, nome VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, email VARCHAR(255), senha VARCHAR(32) NOT NULL, cargo VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('cpf')";
        $criar_tabela = mysqli_query($conexao, $sql1);
    endif;
    mysqli_close($conexao); 
?>