<?php

class CadastroAvaliacaoController extends RenderView
{
    public function index()
    {
        $model = new PerguntaModel();
        $idSetor = 1; //Por enquanto não foi implementado a seleção de setor
        $pergunta = $model->buscarPerguntaAleatoriaPorSetor($idSetor);

        $this->loadView('cadastroAvaliacao', [
            'pergunta' => $pergunta
        ]); 
    }
}