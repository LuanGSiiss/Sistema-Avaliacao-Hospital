<?php

class Exemplo extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function fetch()
    {
        $sql = "SELECT * FROM perguntas ORDER BY id_pergunta;";
        $stm = $this->pdo->query($sql);
        $resultado = $stm->fetchAll();

        return $resultado;
    }
}