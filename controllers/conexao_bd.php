<?php

//Script para conexão com o Banco de Dados

$servername = "localhost";
$username = "root";
$password = "";
$nome_bd = "sistema_web";
$conexao = mysqli_connect($servername, $username, $password, $nome_bd);

//
//If para caso ocorra algum erro na conexão com o Banco de Dados

if ($conexao->connect_error) {
    die("Falha na conexao: " . $conexao->connect_error);
    include_once("criar_bd.php");
}

// ?>