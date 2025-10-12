<?php

class AvaliacaoController extends RenderView
{
    public function formularioAvaliacao(array $mensagens = [], array $avaliacaoPreenchida = [])
    {
        try {
            if(!class_exists('PerguntaModel')) {
                throw new Exception("Classe 'PerguntaModel' não existe.");
            }

            $setor = (int) $_GET['setor'] ?? null;
            $perguntaModel = new PerguntaModel();
            $pergunta = $perguntaModel->buscarPerguntaAleatoriaPorSetor($setor);
    
            $this->loadView('avaliacao.incluirAvaliacao', [
                'pergunta' => $pergunta,
                'avaliacaoPreenchida' => $avaliacaoPreenchida,
                'mensagens' => $mensagens
            ]); 
        } catch(Exception $e) {
            $this->tratarErroRetornoJson($e); 
        }
    }

    public function registrarAvaliacao()
    {
        try {
            $dados = [
                'idSetor'       => 1, //Por enquanto não foi implementado a seleção de setor
                'idPergunta'    => (int) $_POST['id_pergunta'] ?? null,
                'idDispositivo' => 1, //Por enquanto não foi implementado a seleção de dispositivo
                'nota'          => (int) $_POST['nota'] ?? null,
                'feedback'      => trim($_POST['feedback']) ?? ''
            ];

            if(!class_exists('AvaliacaoModel')) {
                throw new Exception("Classe 'AvaliacaoModel' não existe.");
            }

            $avaliacaoModel = new AvaliacaoModel();
            $avaliacaoModel->validarCampos($dados);

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
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioAvaliacao(['erroRegistro' => $mensagemErro], $dados); 
        }
    }
    
    public function exibirConsulta()
    {
        $this->loadView('avaliacao.consultaAvaliacoes', []); 
    }

    public function BuscarAvaliacoes()
    {
        try {
            if(!class_exists('AvaliacaoModel')) {
                throw new Exception("Classe 'AvaliacaoModel' não existe.");
            }

            $avaliacaoModel = new AvaliacaoModel();
            $avaliacoesBase = $avaliacaoModel->BuscarTodas();

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
            
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'avaliacoes' => $arrayAvaliacoes
                ] 
            ]);
        } catch (Exception $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    private function tratarErroRetornoJson(Throwable $e) {
        $httpCode = 500;
        $mensagem = "Erro inesperado ao tratar a requisição";
        
        if ($e instanceof PDOException) {
            $mensagem = "Erro de banco de dados: " . $e->getMessage();
        } elseif($e instanceof Exception) {
            $httpCode = 400;
            $mensagem = "Ocorreu um erro inesperado: " . $e->getMessage();
        } elseif($e instanceof Error) {
            $mensagem = "Erro fatal: " . $e->getMessage();
        }

        if (!mb_check_encoding($mensagem, 'UTF-8')) {
            $mensagem = mb_convert_encoding($mensagem, 'UTF-8', 'auto');
        }

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($httpCode);
        echo json_encode([
            'status' => 'erro',
            'message' => $mensagem
        ], JSON_UNESCAPED_UNICODE);
    }
}