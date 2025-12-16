<?php

class AvaliacaoModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarTodas():array
    {
        $sqlBusca = "SELECT id_avaliacao, id_setor, id_pergunta, id_dispositivo, nota, feedback_textual, datahora_cadastro 
                        FROM avaliacoes 
                        ORDER BY id_avaliacao;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();
    
        return $resultado;
    }

    public function registrar(Avaliacao $avaliacao):bool
    {
        try {
            $sqlInsertAvaliacao = "INSERT INTO avaliacoes(id_setor, id_pergunta, id_dispositivo, nota, feedback_textual, datahora_cadastro)
                                    VALUES(:idSetor, :idPergunta, :idDispositivo, :nota, :feedbackTextual, :datahoraCadastro);";

            $stmt = $this->pdo->prepare($sqlInsertAvaliacao);
            $stmt->bindValue(':idSetor', $avaliacao->getIdSetor(), PDO::PARAM_INT);
            $stmt->bindValue(':idPergunta', $avaliacao->getIdPergunta(), PDO::PARAM_INT);
            $stmt->bindValue(':idDispositivo', $avaliacao->getIdDispositivo(), PDO::PARAM_INT);
            $stmt->bindValue(':nota', $avaliacao->getNota(), PDO::PARAM_INT);
            $stmt->bindValue(':feedbackTextual', $avaliacao->getFeedback(), PDO::PARAM_STR);
            $stmt->bindValue(':datahoraCadastro', $avaliacao->getDatahoraCadastro(), PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}