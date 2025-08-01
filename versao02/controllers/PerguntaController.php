<?php

class PerguntaController extends RenderView
{
    public function exibirConsulta()
    {
        $this->loadView('pergunta.consultaPerguntas', []); 
    }

    public function buscarPerguntas()
    {
        $perguntaModel = new PerguntaModel();
        
        try {
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
        }
    }

    public function formularioIncluir(array $mensagens = [])
    {
        $setorModel = new SetorModel();
        $setoresAtivos = $setorModel->BuscarSetoresAtivos();

        $this->loadView('pergunta.incluirPergunta', [
            'setoresAtivos' => $setoresAtivos,
            'mensagens' => $mensagens
        ]);
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

        } catch(Exception $e) {
            $this->formularioIncluir(['erroRegistroPergunta' => $e->getMessage()]);
        }
    }

    public function formularioAlterar(int $idPergunta, array $mensagens = [])
    {
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

        } catch(Exception $e) {
            $this->formularioAlterar($idPergunta, ['erroRegistroPergunta' => $e->getMessage()]);
        }
    }

    public function visualizarPergunta($idPergunta)
    {
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
    }

    public function excluirPergunta($idPerguntaParametro)
    {
        $perguntaModel = new PerguntaModel();
        
        try {
            $idPergunta = (int) $idPerguntaParametro;

            $perguntaModel->excluir($idPergunta);
            $mensagemSucesso = 'Pergunta com id ' . $idPergunta. ' excluída com sucesso';

            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'message' => $mensagemSucesso
                ] 
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'erro',
                'message' => $e->getMessage() 
            ]);
        }
    }

    
}

