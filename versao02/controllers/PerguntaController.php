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
            //valida se os campos estão preechidos
            if( (!isset($_POST['texto_pergunta']) || trim($_POST['texto_pergunta']) == "") || (!isset($_POST['todos_setores']) && (!isset($_POST['setores']) || !is_array($_POST['setores']) || $_POST['setores'] == [] )) ) {
                throw new Exception("Nem todos os campos obrigatórios foram informados.");
            }

            $textoPergunta = trim($_POST['texto_pergunta']);
            $todosSetores = !empty($_POST['todos_setores']);
            $setores = $_POST['setores'] ?? [];
            
            // Validador do tipo
            // if(!is_string($textoPergunta)){
            //     throw new Exception("O texto da pergunta deve ser do tipo string.");
            // } elseif(!$todosSetores && !is_array($setores)) {
            //     throw new Exception("Os setores deve ser do tipo array.");
            // }

            $pergunta = new Pergunta(null, $textoPergunta, $todosSetores);
            $perguntaModel = new PerguntaModel();

            $sucesso = $perguntaModel->registrar($pergunta, $setores);

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
            //valida se os campos estão preechidos
            if( (!isset($_POST['texto_pergunta']) || trim($_POST['texto_pergunta']) == "") || (!isset($_POST['todos_setores']) && (!isset($_POST['setores']) || !is_array($_POST['setores']) || $_POST['setores'] == [] )) ) {
                throw new Exception("Nem todos os campos obrigatórios foram informados.");
            }

            $textoPergunta = trim($_POST['texto_pergunta']);
            $todosSetores = !empty($_POST['todos_setores']);
            $setores = $_POST['setores'] ?? [];
            
            //Validador do tipo
            // if(!is_string($textoPergunta)){
            //     throw new Exception("O texto da pergunta deve ser do tipo string.");
            // } elseif(!$todosSetores && !is_array($setores)) {
            //     throw new Exception("Os setores deve ser do tipo array.");
            // }

            $pergunta = new Pergunta($idPergunta, $textoPergunta, $todosSetores);
            $perguntaModel = new PerguntaModel();

            $sucesso = $perguntaModel->alterar($pergunta, $setores);

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

    private function validarCamposPergunta($idPergunta, $textoPergunta, $todosSetores, $status, $setores, $alteracao = false) {
        //Separar todas as validações por cada campo, todas do id, depois todas do texto e etc
        //Validar tipo
        if(!is_int($idPergunta) && $alteracao) {
            return throw new Exception("O Código da pergunta deve ser do tipo inteiro.");
        } 
        
        if(!is_string($textoPergunta)){
            return throw new Exception("O Texto da pergunta deve ser do tipo string.");
        } 
        
        if(!is_bool($todosSetores)) {
            return throw new Exception("A informação de Todos os Setores deve do tipo boolean.");
        } 
        if(!is_int($status) && $status <> null) {
            return throw new Exception("O Status da pergunta deve ser do tipo inteiro.");
        } 
        if(!$todosSetores && !is_array($setores)) {
            return throw new Exception("Os setores deve ser do tipo array.");
        }
    }
}

