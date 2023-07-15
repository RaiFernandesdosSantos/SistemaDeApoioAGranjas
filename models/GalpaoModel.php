<?php
require_once "Conexao.php";

class GalpaoModel {
    private $bd;
    private $tabela = "galpao";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($identificacao, $qtdeBaia, $totalPorcos, $funcao) {
        $sql = "INSERT INTO $this->tabela (identificacao, qtdeBaia, totalPorco, funcao) VALUES (?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$identificacao, $qtdeBaia, $totalPorcos, $funcao]);
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