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
            
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'perguntas' => $arrayPerguntas
                ] 
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => "Ocorreu um erro interno no servidor ao processar a requisição: " . $e->getMessage() 
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'erro',
                'message' => "Ocorreu um erro inesperado ao processar a requisição: " . $e->getMessage() 
            ]);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => "Erro fatal: " . $e->getMessage()
            ]);
        }
    }

    public function formularioIncluir(array $mensagens = [])
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();

            $this->loadView('pergunta.incluirPergunta', [
                'setoresAtivos' => $setoresAtivos,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página.'
            ]);
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
            
            $perguntaModel = new PerguntaModel();
            $perguntaModel->validarCamposPergunta($dados);

            $pergunta = new Pergunta(
                null, 
                $dados['textoPergunta'], 
                $dados['todosSetores']
            );

            $sucesso = $perguntaModel->registrar($pergunta, $dados['setores']);

            if($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Pergunta cadastrada com Sucesso"]);
            }

        } catch (Exception $e) {
            $this->formularioIncluir(['erroRegistroPergunta' => $e->getMessage()]);
        } catch (Error $e) {
            $mensagemErro = "Erro fatal: " . $e->getMessage();
            $this->formularioIncluir(['erroRegistroPergunta' => $mensagemErro]);
        }
    }

    public function formularioAlterar(int $idPergunta, array $mensagens = [])
    {
        try {
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
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página.'
            ]);
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

            $perguntaModel = new PerguntaModel();
            $perguntaModel->validarCamposPergunta($dados, true);

            $pergunta = new Pergunta(
                $dados['idPergunta'], 
                $dados['textoPergunta'], 
                $dados['todosSetores'],
            );

            $sucesso = $perguntaModel->alterar($pergunta, $dados['setores']);

            if($sucesso) {
                $this->formularioAlterar($idPergunta, ['sucessoMensagem' => "Pergunta alterada com Sucesso"]); 
            }

        } catch (Exception $e) {
            $this->formularioAlterar($idPergunta, ['erroRegistroPergunta' => $e->getMessage()]);
        } catch (Error $e) {
            $mensagemErro = "Erro fatal: " . $e->getMessage();
            $this->formularioIncluir(['erroRegistroPergunta' => $mensagemErro]);
        }
    }

    public function visualizarPergunta(int $idPergunta)
    {
        try {
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
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => 'Erro ao carregar a página.'
            ]);
        }
    }

    public function excluirPergunta(int $idPerguntaParametro)
    {
        try {
            $perguntaModel = new PerguntaModel();
            $idPergunta = (int) $idPerguntaParametro;

            $linhasAfetadas = $perguntaModel->excluir($idPergunta);

            if ($linhasAfetadas === 0) {
                throw new Exception("Nenhuma pergunta foi excluída. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Pergunta com id ' . $idPergunta. ' excluída com sucesso';

            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'message' => $mensagemSucesso
                ] 
            ]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => "Erro de banco de dados: " . $e->getMessage() 
            ]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode([
                'status' => 'erro',
                'message' => "Ocorreu um erro inesperado ao processar a requisição: " . $e->getMessage() 
            ]);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'erro',
                'message' => "Erro fatal: " . $e->getMessage()
            ]);
        }
    }
}

