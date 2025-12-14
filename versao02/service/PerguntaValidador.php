<?php

class PerguntaValidador {
    private PerguntaModel $perguntaModel;

    public function __construct(PerguntaModel $perguntaModel) 
    {
        $this->perguntaModel = $perguntaModel;
    }

    public function validarDuplicidade(Pergunta $pergunta, bool $alteracao = false):void
    {
        $registroDuplicado = $this->perguntaModel->existePerguntaComTexto($pergunta); 

        if ($registroDuplicado && !($alteracao && $registroDuplicado['id_pergunta'] === $pergunta->getIdPergunta())) {
            throw new Exception("Já existe uma Pergunta cadastra com esse Texto.");
        }
    }

    public function validarCampos(array $dados, bool $alteracao = false) 
    {
        // ID
        if($alteracao) {
            if (empty($dados['idPergunta']) || !is_int($dados['idPergunta']) || $dados['idPergunta'] <= 0) {
                throw new Exception("ID da pergunta inválido.");
            }
        }

        // Texto da Pergunta
        if (!is_string($dados['textoPergunta']) || trim($dados['textoPergunta']) === '' || mb_strlen(trim($dados['textoPergunta'])) > 350) {
            throw new Exception("Texto da pergunta inválido ou excede 350 caracteres.");
        }

        // todosSetores
        if (!isset($dados['todosSetores']) || !is_bool($dados['todosSetores'])) {
            throw new Exception("'todosSetores' deve ser booleano.");
        }

        // setores
        if (!$dados['todosSetores']) {
            if (empty($dados['setores']) || !is_array($dados['setores'])) {
                throw new Exception("Setores obrigatórios quando 'todosSetores' é falso.");
            }
        }

        // status
        if (isset($dados['status']) && (!is_int($dados['status']) || !in_array($dados['status'], [0, 1], true))) {
            throw new Exception("Status deve ser 0 ou 1.");
        }
    }
}