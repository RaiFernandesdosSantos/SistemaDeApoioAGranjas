<?php
    include_once("conexao_bd.php");
    $tabela = "usuario";
    $tabela1 = "galpao";
    $tabela2 = "baia";
    $sql = "SHOW TABLES LIKE '".$tabela."'";
    $sql1 = "SHOW TABLES LIKE '".$tabela1."'";
    $sql2 = "SHOW TABLES LIKE '".$tabela2."'";
    $resultado = mysqli_query($conexao, $sql);
    $resultado1 = mysqli_query($conexao, $sql1);
    $resultado2 = mysqli_query($conexao, $sql2);
    if(mysqli_num_rows($resultado) == 1):
        mysqli_close($conexao);
        else:
            $criar = "CREATE TABLE usuario(id int NOT NULL AUTO_INCREMENT, nome VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, senha VARCHAR(32) NOT NULL, cargo VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('cpf'))";
            $criar_tabela = mysqli_query($conexao, $sql1);
    endif;
    if(mysqli_num_rows($resultado1) == 1):
        mysqli_close($conexao);
        else:
            $criar1 = "CREATE TABLE galpao(id int NOT NULL AUTO_INCREMENT, identificacao VARCHAR(255) NOT NULL, qtde_baias int NOT NULL, total_porcos int NOT NULL, funcao VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('identificacao'))";
            $criar_tabela1 = mysqli_query($conexao, $sql1);
    endif;
    if(mysqli_num_rows($resultado2) == 1):
        mysqli_close($conexao);
        else:
            $criar2 = "CREATE TABLE baia(id int NOT NULL AUTO_INCREMENT, id_galpao int NOT NULL, identificacao VARCHAR(255) NOT NULL, qtde_porcos int, capacidade_total_porcos int NOT NULL, media_peso double, PRIMARY KEY('id'), UNIQUE KEY('identificacao'))";
            $criar_tabela2 = mysqli_query($conexao, $sql1);
    endif;
?>