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
        $sqlBusca = "SELECT id_avaliacao, id_setor, id_pergunta, id_dispositivo, nota, feedback_textual, datahora_cadastro 
                    FROM avaliacoes 
                    ORDER BY id_avaliacao;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();
    
        return $resultado;
    }

    public function registrar(Avaliacao $avaliacao)
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

    public function validarCampos(array $dados) 
    {
        // ID Setor
        if (empty($dados['idSetor']) || !is_int($dados['idSetor']) || $dados['idSetor'] <= 0) {
            throw new Exception("ID do Setor inválido.");
        }

        // ID Pergunta
        if (empty($dados['idPergunta']) || !is_int($dados['idPergunta']) || $dados['idPergunta'] <= 0) {
            throw new Exception("ID da Pergunta inválido.");
        }

        // ID Dispositivo
        if (empty($dados['idDispositivo']) || !is_int($dados['idDispositivo']) || $dados['idDispositivo'] <= 0) {
            throw new Exception("ID do Dispositivo inválido.");
        }

        // Nota
        if (empty($dados['nota']) || !is_int($dados['nota']) || ($dados['nota'] < 1 || $dados['nota'] > 10)) {
            throw new Exception("Nota da Avaliação inválido.");
        }

        // Feedback Textual
        if (!is_null($dados['feedback']) && (!is_string($dados['feedback']) || trim($dados['feedback']) === '' || mb_strlen(trim($dados['feedback'])) > 350)) {
            throw new Exception("Feedback Textual inválido ou excede 350 caracteres.");
        }

        return true;
    }
}