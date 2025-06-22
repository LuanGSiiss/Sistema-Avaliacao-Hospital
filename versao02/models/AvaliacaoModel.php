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

    public function registrar(Avaliacao $avaliacao)
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {

            $sql = "INSERT INTO avaliacoes(id_setor, id_pergunta, id_dispositivo, nota, feedback_textual, datahora_cadastro)
                        VALUES(:id_setor, :id_pergunta, :id_dispositivo, :nota, :feedback_textual, :datahora_cadastro);";

            $stmt = $this->pdo->prepare($sql);
            
            $sucesso = $stmt->execute([
                'id_setor'          => $avaliacao->id_setor,
                'id_pergunta'       => $$avaliacao->id_pergunta,
                'id_dispositivo'    => $avaliacao->id_dispositivo,
                'nota'              => $avaliacao->nota,
                'feedback_textual'  => $avaliacao->feedback_textual,
                'datahora_cadastro' => $avaliacao->datahora_cadastro
            ]);

            if(!$sucesso) {
                $erro = $stmt->errorInfo()[2] ?? 'Erro desconhecido.';
                throw new Exception("Falha ao registrar avaliação: " . $erro);
            }

            return true;
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }
}