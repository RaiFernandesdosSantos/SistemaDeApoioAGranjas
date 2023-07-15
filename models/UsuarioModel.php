<?php
require_once "Conexao.php";

class UsuarioModel {
    private $bd;
    private $tabela = "usuario";

    function __construct() {
        $this->bd = new Conexao();
    }

    public function listar() {
        $sql = "SELECT * FROM $this->tabela";
        return $this->bd->singleQuery($sql, []);
    }

    public function add($nome, $cpf, $senha, $cargo) {
        $sql = "INSERT INTO $this->tabela (nome, cpf, senha, cargo) VALUES (?, ?, ?, ?)";
        return $this->bd->singleQuery($sql, [$nome, $cpf, $senha, $cargo]);
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