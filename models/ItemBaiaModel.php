<?php
require_once "Conexao.php";

class ItemBaiaModel {
    private $bd;
    private $tabela = "itemBaia";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($idBaia, $idUsuario, $data, $qtde, $idItem) {
        $sql = "INSERT INTO $this->tabela (idBaia, idUsuario, dataHora, qtde, idItem) VALUES (?, ?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$idBaia, $idUsuario, $data, $qtde]);
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