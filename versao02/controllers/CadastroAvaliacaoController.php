<?php

use FFI\Exception;

class CadastroAvaliacaoController extends RenderView
{
    public function index()
    {
        try {
            $model = new PerguntaModel();
            $idSetor = 1; //Por enquanto não foi implementado a seleção de setor
            $pergunta = $model->buscarPerguntaAleatoriaPorSetor($idSetor);
    
            $this->loadView('avaliacao.cadastroAvaliacao', [
                'pergunta' => $pergunta
            ]); 
        } catch(Exception $e) {
            $mensagemErroPergunta = $e->getMessage();

            $this->loadView('avaliacao.cadastroAvaliacao', [
                'ErroPergunta' => $mensagemErroPergunta
            ]); 
        }
        
    }

    public function registrarAvaliacao()
    {
        try {
            $idSetor = 1; //Por enquanto não foi implementado a seleção de setor
            $idPergunta = $_POST['id_pergunta'];
            $idDispositivo = 1; //Por enquanto não foi implementado a seleção de dispositivo
            $nota = $_POST['nota'];
            $feedback = $_POST['feedback'];
            date_default_timezone_set('America/Sao_Paulo');
            $dataHora = date('Y-m-d H:i:s');

            $avaliacao = new Avaliacao($idSetor, $idPergunta, $idDispositivo, $nota, $feedback, $dataHora);
            $model = new AvaliacaoModel();

            $sucesso = $model->registrar($avaliacao);
            
            if($sucesso) {
                $this->loadView('avaliacao.agradecimento', []); 
            }
            
        } catch(Exception $e) {
            $mensagemErroRegistroAvaliacao = $e->getMessage();

            $this->loadView('avaliacao.cadastroAvaliacao', [
                'erroRegistroAvaliacao' => $mensagemErroRegistroAvaliacao
            ]); 
        }
    }
}