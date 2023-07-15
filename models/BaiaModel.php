<?php
require_once "Conexao.php";

class BaiaModel {
    private $bd;
    private $tabela = "baia";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($idGalpao, $identificacao, $capacidadeTotal) {
        $sql = "INSERT INTO $this->tabela (idGalpao, identificacao, capacidadeTotal) VALUES (?, ?, ?)";
        return $this->bd->singleQuery($sql, [$idGalpao, $identificacao, $capacidadeTotal]);
    }

    public function listarPorId($id) {
        $sql = "SELECT * FROM $this->tabela WHERE id = ?";
        return $this->bd->singleQuery($sql, [$id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->tabela WHERE id = ?";
        return $this->bd->singleQuery($sql, [$id]);
    }
}
?>