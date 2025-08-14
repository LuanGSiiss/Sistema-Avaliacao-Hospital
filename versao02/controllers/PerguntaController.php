<?php

class PerguntaController extends RenderView
{
    public function exibirConsulta()
    {
        $this->loadView('pergunta.consultaPerguntas', []);
    }

    public function buscarPerguntas()
    {
        try {
            if(!class_exists('PerguntaModel')) {
                throw new Exception("Classe 'PerguntaModel' não existe.");
            }
            
            $perguntaModel = new PerguntaModel();
            $perguntasBase = $perguntaModel->BuscarTodas();
            
            $arrayPerguntas = array_map(function ($registro) {
                return [
                    'id_pergunta'    => $registro['id_pergunta'], 
                    'texto_pergunta' => $registro['texto_pergunta'], 
                    'todos_setores'  => $registro['todos_setores'], 
                    'status'         => $registro['status']
                ];
            }, $perguntasBase);
            
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'perguntas' => $arrayPerguntas
                ] 
            ], JSON_UNESCAPED_UNICODE);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoAjax($e);
        }
    }

    public function formularioIncluir(array $mensagens = [], array $perguntaPreenchida = [])
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();

            $this->loadView('pergunta.incluirPergunta', [
                'setoresAtivos' => $setoresAtivos,
                'perguntaPreenchida' => $perguntaPreenchida,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function registrarPergunta()
    {
        try {
            $dados = [
                'textoPergunta' => trim($_POST['texto_pergunta']) ?? '',
                'todosSetores'  => !empty($_POST['todos_setores']),
                'setores'       => $_POST['setores'] ?? []
            ];

            if(!class_exists('PerguntaModel')) {
                throw new Exception("Classe 'PerguntaModel' não existe.");
            }
            
            $perguntaModel = new PerguntaModel();
            $perguntaModel->validarCamposPergunta($dados);

            $pergunta = new Pergunta(
                null, 
                $dados['textoPergunta'], 
                $dados['todosSetores']
            );

            $sucesso = $perguntaModel->registrar($pergunta, $dados['setores']);

            if ($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Pergunta cadastrada com Sucesso"]);
            }

        } catch (Throwable $e) {
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioIncluir(['erroRegistroPergunta' => $mensagemErro], $dados); 
        } 
    }

    public function formularioAlterar(int $idPergunta, array $mensagens = [], array $perguntaPreenchida = [])
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            } elseif(!class_exists('PerguntaModel')) {
                throw new Exception("Classe 'PerguntaModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();
    
            $perguntaModel = new PerguntaModel();
            $pergunta = $perguntaModel->buscarPorId($idPergunta);
    
            $perguntaSetores = $perguntaModel->buscarSetoresPorPergunta($idPergunta);
            $perguntaSetoresArray = array_map(function ($registro) {
                return $registro['id_setor'];
            }, $perguntaSetores);
    
            $this->loadView('pergunta.alterarPergunta', [
                'setoresAtivos' => $setoresAtivos,
                'pergunta' => $pergunta,
                'perguntaSetores' => $perguntaSetoresArray,
                'perguntaPreenchida' => $perguntaPreenchida,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function alterarPergunta(int $idPergunta)
    {
        try {

            $dados = [
                'idPergunta' => $idPergunta,
                'textoPergunta' => trim($_POST['texto_pergunta']) ?? '',
                'todosSetores'  => !empty($_POST['todos_setores']),
                'setores'       => $_POST['setores'] ?? []
            ];

            if(!class_exists('PerguntaModel')) {
                throw new Exception("Classe 'PerguntaModel' não existe.");
            }
            
            $perguntaModel = new PerguntaModel();
            $perguntaModel->validarCamposPergunta($dados, true);

            $pergunta = new Pergunta(
                $dados['idPergunta'], 
                $dados['textoPergunta'], 
                $dados['todosSetores'],
            );

            $sucesso = $perguntaModel->alterar($pergunta, $dados['setores']);

            if ($sucesso) {
                $this->formularioAlterar($idPergunta, ['sucessoMensagem' => "Pergunta alterada com Sucesso"]); 
            } 

        } catch (Throwable $e) {
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioAlterar($idPergunta, ['erroRegistroPergunta' => $mensagemErro], $dados); 
        }
    }

    public function visualizarPergunta(int $idPergunta)
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            } elseif(!class_exists('PerguntaModel')) {
                throw new Exception("Classe 'PerguntaModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();
    
            $perguntaModel = new PerguntaModel();
            $pergunta = $perguntaModel->buscarPorId($idPergunta);
    
            $perguntaSetores = $perguntaModel->buscarSetoresPorPergunta($idPergunta);
            $perguntaSetoresArray = array_map(function ($registro) {
                return $registro['id_setor'];
            }, $perguntaSetores);
    
            $this->loadView('pergunta.visualizarPergunta', [
                'setoresAtivos' => $setoresAtivos,
                'pergunta' => $pergunta,
                'perguntaSetores' => $perguntaSetoresArray
            ]);
        } catch (Throwable $e) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página: ' . $e->getMessage()
            ], JSON_UNESCAPED_UNICODE);
        }
    }

    public function excluirPergunta(int $idPerguntaParametro)
    {
        try {
            $perguntaModel = new PerguntaModel();
            $idPergunta = (int) $idPerguntaParametro;

            $registrosAfetadas = $perguntaModel->excluir($idPergunta);

            if ($registrosAfetadas === 0) {
                throw new Exception("Nenhuma pergunta foi excluída. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Pergunta com id ' . $idPergunta. ' excluída com sucesso';

            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'message' => $mensagemSucesso
                ] 
            ], JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            $this->tratarErroRetornoAjax($e);
        }
    }

    private function tratarErroRetornoAjax(Throwable $e) {
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
