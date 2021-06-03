<?php
    include_once("conexao_bd.php");
    $bd = "CREATE DATABASE sistema_web";
    $salvar = mysqli_query($conexao, $bd);
    $sql = "SHOW TABLES LIKE usuario";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) == 1):
        break;
        else:
            $criar = "CREATE TABLE usuario(id int NOT NULL AUTO_INCREMENT, nome VARCHAR(255) NOT NULL, cpf VARCHAR(11) NOT NULL, senha VARCHAR(32) NOT NULL, cargo VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('cpf'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    $sql = "SHOW TABLES LIKE galpao";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) == 1):
        break;
        else:
            $criar = "CREATE TABLE galpao(id int NOT NULL AUTO_INCREMENT, identificacao VARCHAR(255) NOT NULL, qtde_baias int NOT NULL, total_porcos int NOT NULL, funcao VARCHAR(11) NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('identificacao'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    $sql = "SHOW TABLES LIKE baia";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) == 1):
        break;
        else:
            $criar = "CREATE TABLE baia(id int NOT NULL AUTO_INCREMENT, id_galpao int NOT NULL, identificacao VARCHAR(255) NOT NULL, capacidade_total_porcos int NOT NULL, PRIMARY KEY('id'), UNIQUE KEY('identificacao'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    $sql = "SHOW TABLES LIKE historico_baia";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) == 1):
        break;
        else:
            $criar = "CREATE TABLE historico_baia(id int NOT NULL AUTO_INCREMENT, id_baia int NOT NULL, id_usuario int NOT NULL, data_hora DATETIME NOT NULL, qtde_porcos int, media_peso double, motivo VARCHAR(255), PRIMARY KEY('id'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    $sql = "SHOW TABLES LIKE item";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs) == 1):
        break;
        else:
            $criar = "CREATE TABLE item(id int NOT NULL AUTO_INCREMENT, nome VARCHAR(255) NOT NULL, unidade VARCHAR(30) NOT NULL, fabricante VARCHAR(255) NOT NULL, qtde double, tipo int NOT NULL, PRIMARY KEY('id'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    $sql = "SHOW TABLES LIKE estoque";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs == 1)):
        break;
        else:
            $criar = "CREATE TABLE estoque(id int NOT NULL AUTO_INCREMENT, id_produto int NOT NULL, id_usuario int NOT NULL, qtde double, data_hora DATETIME, retirada boolean NOT NULL, PRIMARY KEY('id'))";
            $criar_tabela = mysqli_query($conexao, $criar);
    endif;
    $sql = "SHOW TABLES LIKE historico_itens_baia";
    $rs = mysqli_query($conexao, $sql);
    if(mysqli_num_rows($rs == 1)):
        break;
        else:
            $criar = "CREATE TABLE historico_itens_baia(id int NOT NULL AUTO_INCREMENT, id_baia int NOT NULL, id_usuario int NOT NULL, id_item int NOT NULL, qtde double,data_hora DATETIME, PRIMARY KEY ('id'))";
    endif;
    mysqli_close($conexao);
    unset($conexao);
?>