<?php
include_once("conexao_bd.php");

$bd = "CREATE DATABASE sistema_web";
$salvar = mysqli_query($conexao, $bd);


mysqli_close($conexao);
unset($conexao);
?>