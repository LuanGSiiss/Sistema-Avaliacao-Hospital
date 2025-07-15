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
            
            $textoPergunta = $_POST['texto_pergunta'] ?? null;
            $todosSetores = !empty($_POST['todos-setores']);
            $setores = $_POST['setores'] ?? null;

            //Validador do tipo
            if(!is_string($textoPergunta)){
                throw new Exception("O texto da pergunta deve ser do tipo string.");
            } elseif(!is_bool($todosSetores)){
                throw new Exception("A flag Todos Setores deve ser do tipo boolean.");
            } elseif(!$todosSetores && !is_array($setores)) {
                throw new Exception("Os setores deve ser do tipo array.");
            }

            $pergunta = new Pergunta(null, $textoPergunta, $todosSetores);
            $perguntaModel = new PerguntaModel();

            $sucesso = $perguntaModel->registrar($pergunta, $setores);

            if($sucesso) {
                $this->loadView('pergunta.incluirPergunta', [
                    'sucessoMensagem' => "Pergunta cadastrada com Sucesso",
                    'setores' => $setoresAtivos 
                ]); 
            }

        } catch(Exception $e) {
            $this->loadView('pergunta.incluirPergunta', [
                'erroRegistroPergunta' => $e->getMessage(),
                'setores' => $setoresAtivos
            ]); 
        }
    }
}