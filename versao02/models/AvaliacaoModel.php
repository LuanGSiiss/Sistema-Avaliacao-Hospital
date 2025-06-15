<?php

class AvaliacaoModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function BuscarTodas()
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {
            $sql = "SELECT id_avaliacao, id_setor, id_pergunta, id_dispositivo, resposta, feedback_textual, datahora_cadastro 
                        FROM avaliacoes 
                        ORDER BY id_avaliacao;";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }
}