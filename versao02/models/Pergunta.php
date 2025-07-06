<?php

class Pergunta
{
    public $id_pergunta;
    public $texto_pergunta;
    public $todos_setores;
    public $status;

    public function __construct($idPergunta, $textoPergunta, $todosSetores, $situacao) {
        $this->id_pergunta = $idPergunta;
        $this->texto_pergunta = $textoPergunta;
        $this->todos_setores = $todosSetores;
        $this->status = $situacao;
    }
}