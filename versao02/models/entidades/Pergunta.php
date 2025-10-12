<?php

class Pergunta
{
    private ?int $id_pergunta;
    private string $texto_pergunta;
    private bool $todos_setores;
    private int  $status;

    public function __construct(?int $idPergunta, string $textoPergunta, bool $todosSetores, int $situacao = 1) {
        $this->setIdPergunta($idPergunta);
        $this->setTextoPergunta($textoPergunta);
        $this->setTodosSetores($todosSetores);
        $this->setStatus($situacao);
    }

    public function getIdPergunta(): int 
    {
        return $this->id_pergunta;
    }

    public function getTextoPergunta(): string 
    {
        return $this->texto_pergunta;
    }

    public function getTodosSetores(): bool 
    {
        return $this->todos_setores;
    }

    public function getStatus(): int 
    {
        return $this->status;
    }

    // setters
    public function setIdPergunta($idPergunta) 
    {
        if (!is_null($idPergunta) && (!is_int($idPergunta) || $idPergunta <= 0)) {
            throw new InvalidArgumentException("ID da pergunta deve ser inteiro positivo ou nulo.");
        }
        $this->id_pergunta = $idPergunta;
    }

    public function setTextoPergunta($TextoPergunta) 
    {
        if (!is_string($TextoPergunta) || trim($TextoPergunta) === '' || mb_strlen(trim($TextoPergunta)) > 350) {
            throw new InvalidArgumentException("Texto da pergunta inválido ou excede 350 caracteres.");
        }
        $this->texto_pergunta = $TextoPergunta;
    }

    public function setTodosSetores($TodosSetores) 
    {
        if (!is_bool($TodosSetores)) {
            throw new InvalidArgumentException("'TodosSetores' deve ser booleano.");
        }
        $this->todos_setores = $TodosSetores;
    }

    public function setStatus($Status) 
    {
        if (!is_int($Status) || !in_array($Status, [0, 1], true)) {
            throw new InvalidArgumentException("Status deve ser 0 (inativo) ou 1 (ativo).");
        }
        $this->status = $Status;
    }
}