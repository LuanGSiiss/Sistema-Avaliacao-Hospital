<?php

class DispositivoValidador 
{
    private DispositivoModel $dispositivoModel;

    public function __construct(DispositivoModel $dispositivoModel) 
    {
        $this->dispositivoModel = $dispositivoModel;
    }

    public function validarDuplicidade(Dispositivo $dispositivo, bool $alteracao = false):void
    {
        $registroDuplicadoNome = $this->dispositivoModel->existeDispositivoComNome($dispositivo);
        $registroDuplicadoIdentificador = $this->dispositivoModel->existeDispositivoComIdentificador($dispositivo); 

        if ($registroDuplicadoNome && !($alteracao && $registroDuplicadoNome['id_dispositivo'] === $dispositivo->getIdDispositivo())) {
            throw new Exception("Já existe um Dispositivo cadastro com esse Nome.");
        }
        if ($registroDuplicadoIdentificador && !($alteracao && $registroDuplicadoIdentificador['id_dispositivo'] === $dispositivo->getIdDispositivo())) {
            throw new Exception("Já existe um Dispositivo cadastro com esse Código Identificador.");
        }
    }

    public function validarCampos(array $dados, bool $alteracao = false) 
    {
        // ID Dispositivo
        if($alteracao) {
            if (empty($dados['idDispositivo']) || !is_int($dados['idDispositivo']) || $dados['idDispositivo'] <= 0) {
                throw new Exception("ID do Dispositivo inválido.");
            }
        }

        // ID Setor
        if (empty($dados['idSetor']) || !is_int($dados['idSetor']) || $dados['idSetor'] <= 0) {
                throw new Exception("ID do Setor inválido.".$dados['idSetor']);
            }

        // Codigo Identificador
        if (!is_string($dados['codigoIdentificador']) || trim($dados['codigoIdentificador']) === '' || mb_strlen(trim($dados['codigoIdentificador'])) > 7) {
            throw new Exception("Código Identificador do Dispositivo inválido ou excede 7 caracteres.");
        }

        // nome
        if (!is_string($dados['nome']) || trim($dados['nome']) === '' || mb_strlen(trim($dados['nome'])) > 50) {
            throw new Exception("Nome do Dispositivo inválido ou excede 50 caracteres.");
        }

        // status
        if (isset($dados['status']) && (!is_int($dados['status']) || !in_array($dados['status'], [0, 1], true))) {
            throw new Exception("Status deve ser 0 ou 1.");
        }
    }
}