<?php

class AvaliacaoController extends BaseController
{
    public function exibirConsulta():void
    {
        $this->loadView('avaliacao.consultaAvaliacoes', []); 
    }

    public function buscarAvaliacoes():void
    {
        try {
            $avaliacaoModel = new AvaliacaoModel();
            $avaliacoesBase = $avaliacaoModel->buscarTodas();

            $setorModel = new SetorModel();
            $setores = $setorModel->buscarTodas();

            $dispositivoModel = new DispositivoModel();
            $dispositivos = $dispositivoModel->buscarTodas();

            $arrayAvaliacoes = array_map(function ($registro) {
                return [
                    'id_avaliacao'      => $registro['id_avaliacao'], 
                    'id_setor'          => $registro['id_setor'], 
                    'id_pergunta'       => $registro['id_pergunta'], 
                    'id_dispositivo'    => $registro['id_dispositivo'], 
                    'nota'              => $registro['nota'], 
                    'feedback_textual'  => $registro['feedback_textual'], 
                    'datahora_cadastro' => date('d/m/Y H:i:s', strtotime($registro['datahora_cadastro']))
                ];
            }, $avaliacoesBase);
            
            $this->tratarSucessoRetornoJson([
                'avaliacoes'   => $arrayAvaliacoes,
                'setores'      => $setores,
                'dispositivos' => $dispositivos
            ]);
        } catch (Exception $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    // Exibe a página de avaliação
    public function formularioAvaliacao(array $mensagens = []):void
    {
        try {
            $setor = (int) $_GET['setor'] ?? null;
            $dispositivo = (int) $_GET['dispositivo'] ?? null;
            $perguntaModel = new PerguntaModel();
            $pergunta = $perguntaModel->buscarPerguntaAleatoriaPorSetor($setor);
    
            $this->loadView('avaliacao.incluirAvaliacao', [
                'pergunta'    => $pergunta,
                'setor'       => $setor,
                'dispositivo' => $dispositivo,
                'mensagens'   => $mensagens
            ]); 
        } catch(Exception $e) {
            $this->tratarErroRetornoJson($e); 
        }
    }

    public function registrarAvaliacao():void
    {
        try {
            $dados = [
                'idSetor'       => (int) $_GET['setor'] ?? null,
                'idDispositivo' => (int) $_GET['dispositivo'] ?? null,
                'idPergunta'    => (int) $_POST['id_pergunta'] ?? null,
                'nota'          => (int) $_POST['nota'] ?? null,
                'feedback'      => trim($_POST['feedback']) ?? ''
            ];

            $avaliacaoModel = new AvaliacaoModel();
            $avaliacaoValidador = new AvaliacaoValidador($avaliacaoModel);
            $avaliacaoValidador->validarCampos($dados);

            $avaliacao = new Avaliacao(
                null,
                $dados['idSetor'],
                $dados['idPergunta'],
                $dados['idDispositivo'],
                $dados['nota'],
                $dados['feedback'],
            );

            $sucesso = $avaliacaoModel->registrar($avaliacao);
            
            if($sucesso) {
                $this->loadView('avaliacao.agradecimento', []);
            }
        } catch(Exception $e) {
            $this->formularioAvaliacao(['erroRegistro' => "Erro: " . $e->getMessage()]); 
        }
    }
}