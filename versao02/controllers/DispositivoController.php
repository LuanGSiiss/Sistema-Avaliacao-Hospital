<?php

class DispositivoController extends RenderView
{
    public function exibirConsulta()
    {
        $this->loadView('dispositivo.consultaDispositivos', []);
    }

    public function buscarDispositivos()
    {
        try {
            if(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();

            $dispositivoModel = new DispositivoModel();
            $dispositivosBase = $dispositivoModel->BuscarTodas();
            
            $arrayDispositivos = array_map(function ($registro) {
                return [
                    'id_dispositivo'    => $registro['id_dispositivo'], 
                    'id_setor' => $registro['id_setor'], 
                    'codigo_identificador'  => $registro['codigo_identificador'],
                    'nome'  => $registro['nome'], 
                    'status'         => $registro['status']
                ];
            }, $dispositivosBase);
            
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            echo json_encode([
                'status' => 'sucesso',
                'data' => [
                    'dispositivos' => $arrayDispositivos,
                    'setores' => $setoresAtivos
                ] 
            ], JSON_UNESCAPED_UNICODE);
        }  catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function formularioIncluir(array $mensagens = [], array $dispositivoPreenchido = [])
    {
        try {
            if(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();

            $this->loadView('dispositivo.incluirDispositivo', [
                'setoresAtivos' => $setoresAtivos,
                'dispositivoPreenchido' => $dispositivoPreenchido,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function registrarDispositivo()
    {
        try {
            $dados = [
                'idSetor'             => (int) $_POST['setor'] ?? null,
                'codigoIdentificador' => trim($_POST['codigo_identificador']) ?? '',
                'nome'                => trim($_POST['nome']) ?? '',
            ];

            if(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }
            
            $dispositivoModel = new DispositivoModel();
            $dispositivoModel->validarCampos($dados);

            $dispositivo = new Dispositivo(
                null, 
                $dados['idSetor'], 
                $dados['codigoIdentificador'],
                $dados['nome']
            );

            if ($dispositivoModel->validarDuplicacao($dispositivo)) {
                throw new Exception("Já existe um Dispositivo cadastro com esse Código ou Nome.");
            }

            $sucesso = $dispositivoModel->registrar($dispositivo);

            if ($sucesso) {
                $this->formularioIncluir(['sucessoMensagem' => "Dispositivo cadastrado com Sucesso"]);
            }

        } catch (Throwable $e) {
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioIncluir(['erroRegistro' => $mensagemErro], $dados); 
        } 
    }

    public function formularioAlterar(int $idDispositivo, array $mensagens = [], array $dispositivoPreenchido = [])
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            } elseif(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();
    
            $dispositivoModel = new DispositivoModel();
            $dispositivo = $dispositivoModel->buscarPorId($idDispositivo);

            $this->loadView('dispositivo.alterarDispositivo', [
                'setoresAtivos' => $setoresAtivos,
                'dispositivo' => $dispositivo,
                'dispositivoPreenchido' => $dispositivoPreenchido,
                'mensagens' => $mensagens
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function alterarDispositivo(int $idDispositivo)
    {
        try {
            $dados = [
                'idDispositivo' => $idDispositivo,
                'idSetor'             => (int) $_POST['setor'] ?? null,
                'codigoIdentificador' => trim($_POST['codigo_identificador']) ?? '',
                'nome'                => trim($_POST['nome']) ?? '',
            ];

            if(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }
            
            $dispositivoModel = new DispositivoModel();
            $dispositivoModel->validarCampos($dados, true);

            $dispositivo = new Dispositivo(
                $dados['idDispositivo'], 
                $dados['idSetor'], 
                $dados['codigoIdentificador'],
                $dados['nome']
            );

            if ($dispositivoModel->validarDuplicacao($dispositivo, true)) {
                throw new Exception("Já existe um Dispositivo cadastro com esse Código ou Nome.");
            }
            $sucesso = $dispositivoModel->alterar($dispositivo);

            if ($sucesso) {
                $this->formularioAlterar($idDispositivo, ['sucessoMensagem' => "Dispositivo alterado com Sucesso"]); 
            } 

        } catch (Throwable $e) {
            $mensagemErro = "Erro: " . $e->getMessage();
            $this->formularioAlterar($idDispositivo, ['erroRegistro' => $mensagemErro], $dados); 
        }
    }

    public function visualizarDispositivo(int $idDispositivo)
    {
        try {
            if(!class_exists('SetorModel')) {
                throw new Exception("Classe 'SetorModel' não existe.");
            } elseif(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }

            $setorModel = new SetorModel();
            $setoresAtivos = $setorModel->BuscarSetoresAtivos();
    
            $dispositivoModel = new DispositivoModel();
            $dispositivo = $dispositivoModel->buscarPorId($idDispositivo);
    
            $this->loadView('dispositivo.visualizarDispositivo', [
                'setoresAtivos' => $setoresAtivos,
                'dispositivo' => $dispositivo
            ]);
        } catch (Throwable $e) {
            $this->tratarErroRetornoJson($e);
        }
    }

    public function excluirDispositivo(int $idDispositivoParametro)
    {
        try {
            if(!class_exists('DispositivoModel')) {
                throw new Exception("Classe 'DispositivoModel' não existe.");
            }

            $dispositivoModel = new DispositivoModel();
            $idDispositivo = (int) $idDispositivoParametro;

            $registrosAfetadas = $dispositivoModel->excluir($idDispositivo);

            if ($registrosAfetadas === 0) {
                throw new Exception("Nenhum Dispositivo foi excluído. Verifique se o ID informado é válido.");
            }

            $mensagemSucesso = 'Dispositivo com id ' . $idDispositivo. ' excluído com sucesso';

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
