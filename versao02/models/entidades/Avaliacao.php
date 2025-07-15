<?php

class Avaliacao
{
    public $id_setor;
    public $id_pergunta;
    public $id_dispositivo;
    public $nota;
    public $feedback_textual;
    public $datahora_cadastro;

    public function __construct($idSetor, $idPergunta, $idDispositivo, $nota, $feedback, $datahora) {
        $this->id_setor = $idSetor;
        $this->id_pergunta = $idPergunta;
        $this->id_dispositivo = $idDispositivo;
        $this->nota = $nota;
        $this->feedback_textual = $feedback;
        $this->datahora_cadastro = $datahora;
    }
}