<?php

class SetorModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function BuscarSetoresAtivos()
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {
            $sql = "SELECT id_setor, descricao
                        FROM setor 
                        WHERE status = 1
                        ORDER BY descricao;";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }
}