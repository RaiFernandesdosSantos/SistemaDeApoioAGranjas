<?php
require_once "Conexao.php";

class HistoricoBaiaModel {
    private $bd;
    private $tabela = "historicoBaia";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($idBaia, $idUsuario, $data, $qtde, $motivo, $retirada, $peso) {
        $sql = "INSERT INTO $this->tabela (idBaia, idUsuario, dataHora, qtdePorcos, motivo, retirada, mediaPeso) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$idBaia, $idUsuario, $data, $qtde, $motivo, $retirada, $peso]);
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