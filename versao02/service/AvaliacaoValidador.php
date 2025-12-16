<?php

class AvaliacaoValidador 
{
    private AvaliacaoModel $avaliacaoModel;

    public function __construct(AvaliacaoModel $avaliacaoModel) 
    {
        $this->avaliacaoModel = $avaliacaoModel;
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
        if (isset($dados['feedback']) && (!is_string($dados['feedback']) || mb_strlen(trim($dados['feedback'])) > 350)) {
            throw new Exception("Feedback Textual inválido ou excede 350 caracteres.");
        }
    }
}