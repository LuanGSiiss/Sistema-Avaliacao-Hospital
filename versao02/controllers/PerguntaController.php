<?php

class PerguntaController extends BaseController
{
    
    public function exibirConsulta(): void
    {
        $this->loadView('pergunta.consultaPerguntas', []);
    }

    public function buscarPerguntas(): void
    {
        try {
            $perguntaModel = new PerguntaModel();
            $perguntasBase = $perguntaModel->buscarTodas();
            
            $arrayPerguntas = array_map(function ($registro) {
                return [
                    'id_pergunta'    => $registro['id_pergunta'], 
                    'texto_pergunta' => $registro['texto_pergunta'], 
                    'todos_setores'  => $registro['todos_setores'], 
                    'status'         => $registro['status']
                ];
            }, $perguntasBase);

            $this->tratarSucessoRetornoJson([
                'perguntas' => $arrayPerguntas
            ]);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function formularioIncluir(array $mensagens = [], array $perguntaPreenchida = []): void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();

            $this->loadView('pergunta.incluirPergunta', [
                'setoresAtivos'      => $setoresAtivos,
                'perguntaPreenchida' => $perguntaPreenchida,
                'mensagens'          => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function registrarPergunta(): void
    {
        try {
            $dados = [
                'textoPergunta' => trim($_POST['texto_pergunta']) ?? '',
                'todosSetores'  => !empty($_POST['todos_setores']),
                'setores'       => $_POST['setores'] ?? []
            ];
            
            $perguntaModel = new PerguntaModel();
            $perguntaValidador = new PerguntaValidador($perguntaModel);
            $perguntaValidador->validarCampos($dados);

            $pergunta = new Pergunta(
                null, 
                $dados['textoPergunta'], 
                $dados['todosSetores']
            );

            $perguntaValidador->validarDuplicidade($pergunta);

            $sucesso = $perguntaModel->registrar($pergunta, $dados['setores']);

            if ($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Pergunta cadastrada com Sucesso"]);
            }

        } catch (Throwable $e) {
            $this->formularioIncluir(['erroRegistro' => "Erro: " . $e->getMessage()], $dados); 
        } 
    }

    public function formularioAlterar(int $idPergunta, array $mensagens = [], array $perguntaPreenchida = []): void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();
    
            $perguntaModel = new PerguntaModel();
            $pergunta = $perguntaModel->buscarPorId($idPergunta);
    
            $perguntaSetores = $perguntaModel->buscarSetoresPorPergunta($idPergunta);
            $perguntaSetoresArray = array_map(function ($registro) {
                return $registro['id_setor'];
            }, $perguntaSetores);
    
            $this->loadView('pergunta.alterarPergunta', [
                'setoresAtivos'      => $setoresAtivos,
                'pergunta'           => $pergunta,
                'perguntaSetores'    => $perguntaSetoresArray,
                'perguntaPreenchida' => $perguntaPreenchida,
                'mensagens'          => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function alterarPergunta(int $idPergunta): void
    {
        try {
            $dados = [
                'idPergunta'    => $idPergunta,
                'textoPergunta' => trim($_POST['texto_pergunta']) ?? '',
                'todosSetores'  => !empty($_POST['todos_setores']),
                'setores'       => $_POST['setores'] ?? []
            ];
            
            $perguntaModel = new PerguntaModel();
            $perguntaValidador = new PerguntaValidador($perguntaModel);
            $perguntaValidador->validarCampos($dados);

            $pergunta = new Pergunta(
                $dados['idPergunta'], 
                $dados['textoPergunta'], 
                $dados['todosSetores'],
            );

            $perguntaValidador->validarDuplicidade($pergunta, true);

            $sucesso = $perguntaModel->alterar($pergunta, $dados['setores']);

            if ($sucesso) {
                $this->formularioAlterar($idPergunta, ['sucessoMensagem' => "Pergunta alterada com Sucesso"]); 
            } 

        } catch (Throwable $e) {
            $this->formularioAlterar($idPergunta, ['erroRegistro' => "Erro: " . $e->getMessage()], $dados); 
        }
    }

    public function visualizarPergunta(int $idPergunta): void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();
    
            $perguntaModel = new PerguntaModel();
            $pergunta = $perguntaModel->buscarPorId($idPergunta);
    
            $perguntaSetores = $perguntaModel->buscarSetoresPorPergunta($idPergunta);
            $perguntaSetoresArray = array_map(function ($registro) {
                return $registro['id_setor'];
            }, $perguntaSetores);
    
            $this->loadView('pergunta.visualizarPergunta', [
                'setoresAtivos'   => $setoresAtivos,
                'pergunta'        => $pergunta,
                'perguntaSetores' => $perguntaSetoresArray
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function excluirPergunta(int $idPerguntaParametro): void
    {
        try {
            $perguntaModel = new PerguntaModel();
            $idPergunta = (int) $idPerguntaParametro;

            $registrosAfetadas = $perguntaModel->excluir($idPergunta);

            if ($registrosAfetadas === 0) {
                throw new Exception("Nenhuma pergunta foi excluída. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Pergunta com id ' . $idPergunta. ' excluída com sucesso';

            $this->tratarSucessoRetornoJson([
                'message' => $mensagemSucesso
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }
}
