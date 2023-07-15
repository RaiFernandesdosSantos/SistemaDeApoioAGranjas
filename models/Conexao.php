<?php
class Conexao {
    private $host;
    private $user;
    private $password;
    private $nomeBD;
    private $bd;

    //Constructor
    function __construct($host = "localhost", $user = "root", $password = "", $nomeBD = "sistemagranja") {
        $this->setHost($host);
        $this->setUser($user);
        $this->setPass($password);
        $this->setNome($nomeBD);
    }

    //Functions
    public function conectar() {
        $this->bd = new mysqli(
            $this->getHost(),
            $this->getUser(),
            $this->getPass(),
            $this->getNome()
        );
        if ($this->bd->connect_errno) {
            die("Erro de conexao: " . $this->bd->connect_errno . " - " . $this->bd->connect_error);
        }

        return $this->bd;
    }

    public function desconecta() {
        $this->bd->close();
    }

    public function singleQuery($sql, $params) {
        $conn = $this->conectar();
        $stmt = $conn->prepare($sql);

        if (!empty($params)) {
            $type = "";
            $values = [];

            foreach ($params as $value) {
                $type .= $this->getBindType($value);
                $values[] = $value;
            }

            array_unshift($values, $type);

            call_user_func_array(array($stmt, 'bind_param'), $this->refValues($values));
        }

        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQL_ASSOC);

        $stmt->close();

        $this->desconecta();

        return $result;
    }

    public function multiQuery($queries) {
        $conn = $this->conectar();
        $resultSets = array();

        foreach ($queries as $query) {
            $sql = $query['query'];
            $param = $query['params'];

            $stmt = $conn->prepare($sql);

            if (!empty($param)) {
                $types = '';
                $values = [];

                foreach ($param as $p) {
                    $types .= $this->getBindType($p);
                    $values[] = $p;
                }

                array_unshift($values, $types);
                call_user_func_array(array($stmt, 'bind_param'), $this->refValues($values));
            }
        }

        $stmt->execute();
        if ($result = $stmt->get_result()) {
            $resultSets[] = $result->fetch_all(MYSQL_ASSOC);
            $result->free();
        }

        $stmt->close();
        $this->desconecta();

        return $resultSets;
    }

    private function getBindType($value) {
        if (is_int($value)) {
            return 'i';
        } elseif (is_float($value)) {
            return 'd';
        } elseif (is_string($value)) {
            return 's';
        } else {
            return 'b';
        }
    }

    private function refValues($arr) {
        $refs = array();
        foreach ($arr as $key => $value) {
            $refs[$key] = $arr[$key];
        }

        return $refs;
    }

    //Getters and Setters
    public function getHost() {
        return $this->host;
    }
    public function setHost($host) {
        $this->host = $host;
    }

    public function getUser() {
        return $this->user;
    }
    public function setUser($user) {
        $this->user = $user;
    }

    public function getPass() {
        return $this->password;
    }
    public function setPass($pass) {
        $this->password = $pass;
    }

    public function getNome() {
        return $this->nomeBD;
    }
    public function setNome($nome) {
        $this->nomeBD = $nome;
    }

    public function getBd() {
        return $this->bd;
    }
    public function setBd($bd) {
        $this->bd = $bd;
    }
}
?>