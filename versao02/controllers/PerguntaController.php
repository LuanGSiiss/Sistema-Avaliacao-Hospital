<?php

class PerguntaController extends RenderView
{
    public function exibirConsulta()
    {
        $this->loadView('pergunta.consultaPerguntas', []); 
    }

    public function buscarPerguntas()
    {
        $model = new PerguntaModel();
        
        try {
            $perguntasBase = $model->BuscarTodas();
            
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
        $model = new SetorModel();
        $setoresAtivos = $model->BuscarTodosAtivos();

        $this->loadView('pergunta.incluirPergunta', [
            'setoresAtivos' => $setoresAtivos
        ]); 
    }

    public function registrarPergunta()
    {
        $model = new SetorModel();
        $setoresAtivos = $model->BuscarTodosAtivos();

        try {
            $textoPergunta = $_POST['texto_pergunta'] ?? null;
            $todosSetores = !empty($_POST['todos-setores']);
            $setores = $_POST['setores'] ?? null;

            if($textoPergunta && ($todosSetores || (is_array($setores) && count($setores) > 0))) {
                $pergunta = new Pergunta(null, $textoPergunta, $todosSetores, 1);
                $model = new PerguntaModel();

                $sucesso = $model->registrar($pergunta, $setores);

                if($sucesso) {
                    $this->loadView('pergunta.incluirPergunta', [
                        'sucessoMensagem' => "Pergunta cadastrada com Sucesso",
                        'setores' => $setoresAtivos 
                    ]); 
                }

            } else {
                $mensagemErroRegistroPergunta = "Nem todos os campos foram preenchidos";

                $this->loadView('pergunta.incluirPergunta', [
                    'erroRegistroPergunta' => $mensagemErroRegistroPergunta,
                    'setores' => $setoresAtivos
                ]);
            }

        } catch(Exception $e) {
            $mensagemErroRegistroPergunta = $e->getMessage();

            $this->loadView('pergunta.incluirPergunta', [
                'erroRegistroPergunta' => $mensagemErroRegistroPergunta
            ]); 
        }
    }
}