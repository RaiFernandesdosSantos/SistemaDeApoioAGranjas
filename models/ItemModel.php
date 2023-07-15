<?php
require_once "Conexao.php";

class ItemModel {
    private $bd;
    private $tabela = "item";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($nome, $unidade, $fabricante, $tipo) {
        $sql = "INSERT INTO $this->tabela (nome, unidade, fabricante, tipo) VALUES (?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$nome, $unidade, $fabricante, $tipo]);
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