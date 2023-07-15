<?php
require_once "Conexao.php";

class EstoqueModel {
    private $bd;
    private $tabela = "estoque";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($idProduto, $idUsuario, $idFornecedor, $qtde, $data, $retirada, $nf, $lote, $dataCompra, $dataChegada, $vencimento, $preco) {
        $sql = "INSERT INTO $this->tabela (idUsuario, idProduto, idFornecedor, qtde, dataHora, dataCompra, dataChegada, nf, lote, retirada, vencimento, preco) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$idUsuario, $idProduto, $idFornecedor, $qtde, $data, $dataCompra, $dataChegada, $nf, $lote, $retirada, $vencimento, $preco]);
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