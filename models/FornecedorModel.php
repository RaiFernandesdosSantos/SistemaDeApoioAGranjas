<?php
require_once "Conexao.php";

class FornecedorModel {
    private $bd;
    private $tabela = "fornecedor";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($razaoSocial, $fantasia, $cnpj, $telefone, $email, $endereco, $vendedor) {
        $sql = "INSERT INTO $this->tabela (razaoSocial, fantasia, cnpj, telefone, email, endereco, vendedor) VALUES (?, ?, ?, ?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$razaoSocial, $fantasia, $cnpj, $telefone, $email, $endereco, $vendedor]);
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