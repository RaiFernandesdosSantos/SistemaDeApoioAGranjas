<?php
    include_once("conexao_bd.php");
    $tabela = "usuario";
    $sql = "SHOW TABLES LIKE ".$tabela;
    $resultado = mysqli_query($conexao, $sql);
    $tabela = "galpao";
    $sql = "SHOW TABLES LIKE ".$tabela;
    $resultado1 = mysqli_query($conexao, $sql);
    $tabela = "baia";
    $sql = "SHOW TABLES LIKE ".$tabela;
    $resultado2 = mysqli_query($conexao, $sql);
    $tabela = "historico_baia";
    $sql = "SHOW TABLES LIKE ".$tabela;
    $resultado3 = mysqli_query($conexao, $sql);
    $tabela = "item";
    $sql = "SHOW TABLES LIKE ".$tabela;
    $resultado4 = mysqli_query($conexao, $sql);
    $tabela = "estoque";
    $sql = "SHOW TABLES LIKE ".$tabela;
    $resultado5 = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($resultado) == 1):
        mysqli_close($conexao);
        else:
            $criar = "CREATE TABLE usuario(id int NOT NULL AUTO_INCREMENT, nome VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, senha VARCHAR(32) NOT NULL, cargo VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('cpf'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    if(mysqli_num_rows($resultado1) == 1):
        mysqli_close($conexao);
        else:
            $criar = "CREATE TABLE galpao(id int NOT NULL AUTO_INCREMENT, identificacao VARCHAR(255) NOT NULL, qtde_baias int NOT NULL, total_porcos int NOT NULL, funcao VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('identificacao'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    if(mysqli_num_rows($resultado2) == 1):
        mysqli_close($conexao);
        else:
            $criar = "CREATE TABLE baia(id int NOT NULL AUTO_INCREMENT, id_galpao int NOT NULL, identificacao VARCHAR(255) NOT NULL, capacidade_total_porcos int NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('identificacao'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    if(mysqli_num_rows($resultado3) == 1):
        mysqli_close($conexao);
        else:
            $criar = "CREATE TABLE historico_baia(id int NOT NULL AUTO_INCREMENT, id_baia int NOT NULL, id_usuario int NOT NULL, data_hora DATETIME NOT NULL, qtde_porcos int, media_peso double, motivo VARCHAR(255), PRIMARY KEY('id'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    if(mysqli_num_rows($resultado4) == 1):
        mysqli_close($conexao);
        else:
            $criar = "CREATE TABLE item(id int NOT NULL AUTO_INCREMENT, nome VARCHAR(255) NOT NULL, unidade VARCHAR(30) NOT NULL, fabricante VARCHAR(255) NOT NULL, qtde double, PRIMARY KEY('id'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    if(mysqli_num_rows($resultado5 == 1)):
        mysqli_close($conexao);
    else:
        $criar = "CREATE TABLE estoque(id int NOT NULL AUTO_INCREMENT, id_produto int NOT NULL, id_usuario int NOT NULL, qtde double, data_hora DATETIME, retirada boolean NOT NULL, PRIMARY KEY('id'))";
        $criar_tabela = mysqli_query($conexao, $criar);
    endif;
?>