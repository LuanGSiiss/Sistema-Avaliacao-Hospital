<?php

class SetorModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();

        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
    }

    public function BuscarSetoresAtivos(): array
    {
        $sqlBusca = "SELECT id_setor, descricao
                        FROM setores 
                        WHERE status = 1
                        ORDER BY descricao;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();
        
        return $resultado;
    }
}