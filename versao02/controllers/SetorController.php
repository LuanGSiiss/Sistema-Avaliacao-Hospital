<?php

class SetorController extends RenderView
{
    public function exibirConsulta()
    {
        $this->loadView('setor.consultaSetores', []);
    }

    public function buscarSetores()
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }
            
            $setorModel = new SetorModel();
            $setoresBase = $setorModel->BuscarTodas();
            
            $arraySetores = array_map(function ($registro) {
                return [
                    'id_setor'    => $registro['id_setor'], 
                    'descricao' => $registro['descricao'], 
                    'status'         => $registro['status']
                ];
            }, $setoresBase);
            
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'setores' => $arraySetores
                ] 
            ], JSON_UNESCAPED_UNICODE);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function formularioIncluir(array $mensagens = [], array $setorPreenchido = [])
    {
        try {
            $this->loadView('setor.incluirSetor', [
                'setorPreenchido' => $setorPreenchido,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function registrarSetor()
    {
        try {
            $dados = [
                'descricao' => trim($_POST['descricao']) ?? '',
            ];

            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }
            
            $setorModel = new SetorModel();
            $setorModel->validarCampos($dados);

            $setor = new Setor(
                null, 
                $dados['descricao'], 
            );

            $setorModel->validarDuplicidade($setor);

            $sucesso = $setorModel->registrar($setor);

            if ($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Setor cadastrado com Sucesso"]);
            }

        } catch (Throwable $e) {
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioIncluir(['erroRegistro' => $mensagemErro], $dados); 
        } 
    }

    public function formularioAlterar(int $idSetor, array $mensagens = [], array $setorPreenchido = [])
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }
            
            $setorModel = new SetorModel();
            $setor = $setorModel->buscarPorId($idSetor);
    
            $this->loadView('setor.alterarSetor', [
                'setor' => $setor,
                'setorPreenchido' => $setorPreenchido,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function alterarSetor(int $idSetor)
    {
        try {
            
            $dados = [
                'idSetor' => $idSetor,
                'descricao' => trim($_POST['descricao']) ?? ''
            ];
            
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }
            
            $setorModel = new SetorModel();
            $setorModel->validarCampos($dados, true);

            $setor = new Setor(
                $dados['idSetor'],
                $dados['descricao']
            );

            $setorModel->validarDuplicidade($setor, true);

            $sucesso = $setorModel->alterar($setor);

            if ($sucesso) {
                $this->formularioAlterar($idSetor, ['sucessoMensagem' => "Setor alterado com Sucesso"]); 
            } 

        } catch (Throwable $e) {
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioAlterar($idSetor, ['erroRegistro' => $mensagemErro], $dados); 
        }
    }

    public function visualizarSetor(int $idSetor)
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            } 

            $setorModel = new SetorModel();
            $setor = $setorModel->buscarPorId($idSetor);
    
            $this->loadView('setor.visualizarSetor', [
                'setor' => $setor
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function excluirSetor(int $idSetorParametro)
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }

            $setorModel = new SetorModel();
            $idSetor = (int) $idSetorParametro;

            $registrosAfetadas = $setorModel->excluir($idSetor);

            if ($registrosAfetadas === 0) {
                throw new Exception("Nenhum Setor foi excluído. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Setor com id ' . $idSetor. ' excluído com sucesso';

            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'message' => $mensagemSucesso
                ] 
            ], JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
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
