<?php

class Avaliacao
{
    public ?int $id_avaliacao;
    public int $id_setor;
    public int $id_pergunta;
    public int $id_dispositivo;
    public int $nota;
    public string $feedback_textual;
    public string $datahora_cadastro;

    public function __construct(?int $idAvaliacao, int $idSetor, int $idPergunta, int $idDispositivo, int $nota, string $feedback, ?string $datahora = null) {
        $this->setIdAvaliacao($idAvaliacao);
        $this->setIdSetor($idSetor);
        $this->setIdPergunta($idPergunta);
        $this->setIdDispositivo($idDispositivo);
        $this->setNota($nota);
        $this->setFeedbackTextual($feedback);
        $this->setDatahoraCadastro($datahora);
    }

    public function getIdAvaliacao(): int 
    {
        return $this->id_avaliacao;
    }

    public function getIdSetor(): int 
    {
        return $this->id_setor;
    }

    public function getIdPergunta(): int 
    {
        return $this->id_pergunta;
    }

    public function getIdDispositivo(): int 
    {
        return $this->id_dispositivo;
    }

    public function getNota(): int 
    {
        return $this->nota;
    }

    public function getFeedback(): ?string 
    {
        return $this->feedback_textual;
    }

    public function getDatahoraCadastro(): string 
    {
        return $this->datahora_cadastro;
    }

    // setters
    public function setIdAvaliacao($idAvaliacao) 
    {
        if (!is_null($idAvaliacao) && (!is_int($idAvaliacao) || $idAvaliacao <= 0)) {
            throw new InvalidArgumentException("ID da Avaliação deve ser inteiro positivo ou nulo.");
        }
        $this->id_avaliacao = $idAvaliacao;
    }

    public function setIdSetor($idSetor) 
    {
        if (is_null($idSetor) || (!is_int($idSetor) || $idSetor <= 0)) {
            throw new InvalidArgumentException("ID do Setor deve ser inteiro positivo ou nulo.");
        }
        $this->id_setor = $idSetor;
    }

    public function setIdPergunta($idPergunta) 
    {
        if (is_null($idPergunta) || (!is_int($idPergunta) || $idPergunta <= 0)) {
            throw new InvalidArgumentException("ID da Pergunta deve ser inteiro positivo ou nulo.");
        }
        $this->id_pergunta = $idPergunta;
    }

    public function setIdDispositivo($idDispositivo) 
    {
        if (is_null($idDispositivo) || (!is_int($idDispositivo) || $idDispositivo <= 0)) {
            throw new InvalidArgumentException("ID do Dispositivo deve ser inteiro positivo ou nulo.");
        }
        $this->id_dispositivo = $idDispositivo;
    }

    public function setNota($nota) 
    {
        if (is_null($nota) || (!is_int($nota) || ($nota < 1 || $nota > 10))) {
            throw new InvalidArgumentException("Nota da Avaliação deve ser inteiro e estar entre 1 a 10.");
        }
        $this->nota = $nota;
    }

    public function setFeedbackTextual($feedback) 
    {
        if (!is_null($feedback) && !is_string($feedback) || mb_strlen(trim($feedback)) > 350) {
            throw new InvalidArgumentException("Feedback Textual da Avaliação inválido ou excede 350 caracteres.");
        }
        $this->feedback_textual = $feedback;
    }

    public function setDatahoraCadastro($dataHora) 
    {
        if (is_null($dataHora)) {
            date_default_timezone_set('America/Sao_Paulo');
            $dataHora = date('Y-m-d H:i:s');
        }

        $this->datahora_cadastro = $dataHora;
    }
}