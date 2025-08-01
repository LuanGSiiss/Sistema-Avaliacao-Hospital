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
    public function setIdPergunta($IdPergunta) 
    {
        $this->id_pergunta = $IdPergunta;
    }

    public function setTextoPergunta($TextoPergunta) 
    {
        $this->texto_pergunta = $TextoPergunta;
    }

    public function setTodosSetores($TodosSetores) 
    {
        $this->todos_setores = $TodosSetores;
    }

    public function setStatus($Status) 
    {
        $this->status = $Status;
    }
}