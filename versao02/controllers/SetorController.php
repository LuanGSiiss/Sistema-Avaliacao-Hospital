<?php

class SetorController extends BaseController
{
    public function exibirConsulta()
    {
        $this->loadView('setor.consultaSetores', []);
    }

    public function buscarSetores():void
    {
        try {
            $setorModel = new SetorModel();
            $setoresBase = $setorModel->buscarTodas();
            
            $arraySetores = array_map(function ($registro) {
                return [
                    'id_setor'  => $registro['id_setor'], 
                    'descricao' => $registro['descricao'], 
                    'status'    => $registro['status']
                ];
            }, $setoresBase);
            
            $this->tratarSucessoRetornoJson([
                'setores' => $arraySetores
            ]);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function formularioIncluir(array $mensagens = [], array $setorPreenchido = []):void
    {
        try {
            $this->loadView('setor.incluirSetor', [
                'setorPreenchido' => $setorPreenchido,
                'mensagens'       => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function registrarSetor():void
    {
        try {
            $dados = [
                'descricao' => trim($_POST['descricao']) ?? '',
            ];
            
            $setorModel = new SetorModel();
            $setorValidador = new SetorValidador($setorModel);
            $setorValidador->validarCampos($dados);

            $setor = new Setor(
                null, 
                $dados['descricao'], 
            );

            $setorValidador->validarDuplicidade($setor);

            $sucesso = $setorModel->registrar($setor);

            if ($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Setor cadastrado com Sucesso"]);
            }
        } catch (Throwable $e) {
            $this->formularioIncluir(['erroRegistro' => "Erro: " . $e->getMessage()], $dados); 
        } 
    }

    public function formularioAlterar(int $idSetor, array $mensagens = [], array $setorPreenchido = []):void
    {
        try {
            $setorModel = new SetorModel();
            $setor = $setorModel->buscarPorId($idSetor);
    
            $this->loadView('setor.alterarSetor', [
                'setor'           => $setor,
                'setorPreenchido' => $setorPreenchido,
                'mensagens'       => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function alterarSetor(int $idSetor):void
    {
        try {
            $dados = [
                'idSetor'   => $idSetor,
                'descricao' => trim($_POST['descricao']) ?? ''
            ];
            
            $setorModel = new SetorModel();
            $setorValidador = new setorValidador($setorModel);
            $setorValidador->validarCampos($dados, true);

            $setor = new Setor(
                $dados['idSetor'],
                $dados['descricao']
            );

            $setorValidador->validarDuplicidade($setor, true);

            $sucesso = $setorModel->alterar($setor);

            if ($sucesso) {
                $this->formularioAlterar($idSetor, ['sucessoMensagem' => "Setor alterado com Sucesso"]); 
            } 

        } catch (Throwable $e) {
            $this->formularioAlterar($idSetor, ['erroRegistro' => "Erro: " . $e->getMessage()], $dados); 
        }
    }

    public function visualizarSetor(int $idSetor):void
    {
        try {
            $setorModel = new SetorModel();
            $setor = $setorModel->buscarPorId($idSetor);
    
            $this->loadView('setor.visualizarSetor', [
                'setor' => $setor
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function excluirSetor(int $idSetorParametro):void
    {
        try {
            $setorModel = new SetorModel();
            $idSetor = (int) $idSetorParametro;

            $registrosAfetadas = $setorModel->excluir($idSetor);

            if ($registrosAfetadas === 0) {
                throw new Exception("Nenhum Setor foi excluído. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Setor com id ' . $idSetor. ' excluído com sucesso';

            $this->tratarSucessoRetornoJson([
                'message' => $mensagemSucesso
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }
}
