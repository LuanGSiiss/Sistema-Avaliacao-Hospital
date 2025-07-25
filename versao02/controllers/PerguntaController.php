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
                    'id_pergunta'      => $registro['id_pergunta'], 
                    'texto_pergunta'          => $registro['texto_pergunta'], 
                    'todos_setores'       => $registro['todos_setores'], 
                    'status'    => $registro['status']
                ];
            }, $perguntasBase);
            
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'perguntas' => $arrayPerguntas
                ] 
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'status' => 'erro',
                'message' => $e->getMessage() 
            ]);
        }
    }

    public function formularioIncluir()
    {
        $setorModel = new SetorModel();
        $setoresAtivos = $setorModel->BuscarTodosAtivos();

        $this->loadView('pergunta.incluirPergunta', [
            'setoresAtivos' => $setoresAtivos
        ]); 
    }

    public function registrarPergunta()
    {
        $setorModel = new SetorModel();
        $setoresAtivos = $setorModel->BuscarTodosAtivos();

        try {
            //valida se os campos estão preechidos
            if( (!isset($_POST['texto_pergunta']) || trim($_POST['texto_pergunta']) == "") || (!isset($_POST['todos_setores']) && (!isset($_POST['setores']) || !is_array($_POST['setores']) || $_POST['setores'] == [] )) ) {
                throw new Exception("Nem todos os campos obrigatórios foram informados.");
            }

            $textoPergunta = trim($_POST['texto_pergunta']);
            $todosSetores = !empty($_POST['todos_setores']);
            $setores = $_POST['setores'] ?? [];
            
            //Validador do tipo
            if(!is_string($textoPergunta)){
                throw new Exception("O texto da pergunta deve ser do tipo string.");
            } elseif(!$todosSetores && !is_array($setores)) {
                throw new Exception("Os setores deve ser do tipo array.");
            }

            $pergunta = new Pergunta(null, $textoPergunta, $todosSetores);
            $perguntaModel = new PerguntaModel();

            $sucesso = $perguntaModel->registrar($pergunta, $setores);

            if($sucesso) {
                $this->loadView('pergunta.incluirPergunta', [
                    'sucessoMensagem' => "Pergunta cadastrada com Sucesso",
                    'setoresAtivos' => $setoresAtivos 
                ]); 
            }

        } catch(Exception $e) {
            $this->loadView('pergunta.incluirPergunta', [
                'erroRegistroPergunta' => $e->getMessage(),
                'setoresAtivos' => $setoresAtivos
            ]); 
        }
    }

    public function formularioAlterar($idPergunta, $mensagens = [])
    {
        $setorModel = new SetorModel();
        $setoresAtivos = $setorModel->BuscarTodosAtivos();

        $perguntaModel = new PerguntaModel();
        $pergunta = $perguntaModel->buscarPeguntaPorId($idPergunta);

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

    public function alterarPergunta($idPergunta)
    {
        $setorModel = new SetorModel();
        $setoresAtivos = $setorModel->BuscarTodosAtivos();
        
        try {
            //valida se os campos estão preechidos
            if( (!isset($_POST['texto_pergunta']) || trim($_POST['texto_pergunta']) == "") || (!isset($_POST['todos_setores']) && (!isset($_POST['setores']) || !is_array($_POST['setores']) || $_POST['setores'] == [] )) ) {
                throw new Exception("Nem todos os campos obrigatórios foram informados.");
            }

            $textoPergunta = trim($_POST['texto_pergunta']);
            $todosSetores = !empty($_POST['todos_setores']);
            $setores = $_POST['setores'] ?? [];
            
            //Validador do tipo
            if(!is_string($textoPergunta)){
                throw new Exception("O texto da pergunta deve ser do tipo string.");
            } elseif(!$todosSetores && !is_array($setores)) {
                throw new Exception("Os setores deve ser do tipo array.");
            }

            $pergunta = new Pergunta($idPergunta, $textoPergunta, $todosSetores);
            $perguntaModel = new PerguntaModel();

            $sucesso = $perguntaModel->alterar($pergunta, $setores);

            if($sucesso) {
                $this->formularioAlterar($idPergunta, ['sucessoMensagem' => "Pergunta cadastrada com Sucesso"]); 
            }

        } catch(Exception $e) {
            $this->formularioAlterar($idPergunta, ['erroRegistroPergunta' => $e->getMessage()]);
        }
    }

    public function visualizarPergunta($idPergunta)
    {
        $setorModel = new SetorModel();
        $setoresAtivos = $setorModel->BuscarTodosAtivos();

        $perguntaModel = new PerguntaModel();
        $pergunta = $perguntaModel->buscarPeguntaPorId($idPergunta);

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

