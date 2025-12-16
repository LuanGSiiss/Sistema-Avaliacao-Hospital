<?php

class DispositivoController extends BaseController
{
    public function exibirConsulta():void
    {
        $this->loadView('dispositivo.consultaDispositivos', []);
    }

    public function buscarDispositivos():void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();

            $dispositivoModel = new DispositivoModel();
            $dispositivosBase = $dispositivoModel->buscarTodas();
            
            $arrayDispositivos = array_map(function ($registro) {
                return [
                    'id_dispositivo'       => $registro['id_dispositivo'], 
                    'id_setor'             => $registro['id_setor'], 
                    'codigo_identificador' => $registro['codigo_identificador'],
                    'nome'                 => $registro['nome'], 
                    'status'               => $registro['status']
                ];
            }, $dispositivosBase);
            
            $this->tratarSucessoRetornoJson([
                'dispositivos' => $arrayDispositivos,
                'setores'      => $setoresAtivos
            ]);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function formularioIncluir(array $mensagens = [], array $dispositivoPreenchido = []):void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();

            $this->loadView('dispositivo.incluirDispositivo', [
                'setoresAtivos'         => $setoresAtivos,
                'dispositivoPreenchido' => $dispositivoPreenchido,
                'mensagens'             => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function registrarDispositivo():void
    {
        try {
            $dados = [
                'idSetor'             => (int) $_POST['setor'] ?? null,
                'codigoIdentificador' => trim($_POST['codigo_identificador']) ?? '',
                'nome'                => trim($_POST['nome']) ?? '',
            ];
            
            $dispositivoModel = new DispositivoModel();
            $dispositivoValidador = new DispositivoValidador($dispositivoModel);
            $dispositivoValidador->validarCampos($dados);

            $dispositivo = new Dispositivo(
                null, 
                $dados['idSetor'], 
                $dados['codigoIdentificador'],
                $dados['nome']
            );

            $dispositivoValidador->validarDuplicidade($dispositivo);

            $sucesso = $dispositivoModel->registrar($dispositivo);

            if ($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Dispositivo cadastrado com Sucesso"]);
            }
        } catch (Throwable $e) {
            $this->formularioIncluir(['erroRegistro' => "Erro: " . $e->getMessage()], $dados); 
        } 
    }

    public function formularioAlterar(int $idDispositivo, array $mensagens = [], array $dispositivoPreenchido = []):void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();
    
            $dispositivoModel = new DispositivoModel();
            $dispositivo = $dispositivoModel->buscarPorId($idDispositivo);

            $this->loadView('dispositivo.alterarDispositivo', [
                'setoresAtivos'         => $setoresAtivos,
                'dispositivo'           => $dispositivo,
                'dispositivoPreenchido' => $dispositivoPreenchido,
                'mensagens'             => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function alterarDispositivo(int $idDispositivo):void
    {
        try {
            $dados = [
                'idDispositivo'       => $idDispositivo,
                'idSetor'             => (int) $_POST['setor'] ?? null,
                'codigoIdentificador' => trim($_POST['codigo_identificador']) ?? '',
                'nome'                => trim($_POST['nome']) ?? '',
            ];
            
            $dispositivoModel = new DispositivoModel();
            $dispositivoValidador = new DispositivoValidador($dispositivoModel);
            $dispositivoValidador->validarCampos($dados, true);

            $dispositivo = new Dispositivo(
                $dados['idDispositivo'], 
                $dados['idSetor'], 
                $dados['codigoIdentificador'],
                $dados['nome']
            );

            $dispositivoValidador->validarDuplicidade($dispositivo, true);

            $sucesso = $dispositivoModel->alterar($dispositivo);

            if ($sucesso) {
                $this->formularioAlterar($idDispositivo, ['sucessoMensagem' => "Dispositivo alterado com Sucesso"]); 
            } 
        } catch (Throwable $e) {
            $this->formularioAlterar($idDispositivo, ['erroRegistro' => "Erro: " . $e->getMessage()], $dados); 
        }
    }

    public function visualizarDispositivo(int $idDispositivo):void
    {
        try {
            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->buscarSetoresAtivos();
    
            $dispositivoModel = new DispositivoModel();
            $dispositivo = $dispositivoModel->buscarPorId($idDispositivo);
    
            $this->loadView('dispositivo.visualizarDispositivo', [
                'setoresAtivos' => $setoresAtivos,
                'dispositivo'   => $dispositivo
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function excluirDispositivo(int $idDispositivoParametro):void
    {
        try {
            $dispositivoModel = new DispositivoModel();
            $idDispositivo = (int) $idDispositivoParametro;

            $registrosAfetadas = $dispositivoModel->excluir($idDispositivo);

            if ($registrosAfetadas === 0) {
                throw new Exception("Nenhum Dispositivo foi excluído. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Dispositivo com id ' . $idDispositivo. ' excluído com sucesso';

            $this->tratarSucessoRetornoJson([
                'message' => $mensagemSucesso
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }
}
