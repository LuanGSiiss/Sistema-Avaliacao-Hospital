<?php

class Pergunta
{
    public $id_pergunta;
    public $texto_pergunta;
    public $todos_setores;
    public $status;

    public function __construct(?int $idPergunta, string $textoPergunta, bool $todosSetores, int $situacao = 1) {
        $this->id_pergunta = $idPergunta;
        $this->texto_pergunta = $textoPergunta;
        $this->todos_setores = $todosSetores;
        $this->status = $situacao;
    }
}