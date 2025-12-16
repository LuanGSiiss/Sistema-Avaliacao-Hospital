<?php

class SetorValidador 
{
    private SetorModel $setorModel;

    public function __construct(SetorModel $setorModel) 
    {
        $this->setorModel = $setorModel;
    }

    public function validarDuplicidade(Setor $setor, bool $alteracao = false):void 
    {
        $registroDuplicado = $this->setorModel->existeSetorComDescricao($setor); 

        if ($registroDuplicado && !($alteracao && $registroDuplicado['id_setor'] === $setor->getIdSetor())) {
            throw new Exception("Já existe um Setor cadastro com essa Descrição.");
        }
    }

    public function validarCampos(array $dados, bool $alteracao = false):void 
    {
        // ID
        if($alteracao) {
            if (empty($dados['idSetor']) || !is_int($dados['idSetor']) || $dados['idSetor'] <= 0) {
                throw new Exception("ID do Setor inválido.");
            }
        }

        // Descrição
        if (!is_string($dados['descricao']) || trim($dados['descricao']) === '' || mb_strlen(trim($dados['descricao'])) > 50) {
            throw new Exception("Descrição do Setor inválido ou excede 50 caracteres.");
        }

        // status
        if (isset($dados['status']) && (!is_int($dados['status']) || !in_array($dados['status'], [0, 1], true))) {
            throw new Exception("Status deve ser 0 ou 1.");
        }
    }
}