<?php

class Setor
{
    private ?int $id_setor;
    private string $descricao;
    private int  $status;

    public function __construct(?int $idSetor, string $descricao, int $situacao = 1) {
        $this->setIdSetor($idSetor);
        $this->setDescricao($descricao);
        $this->setStatus($situacao);
    }

    public function getIdSetor(): int 
    {
        return $this->id_setor;
    }

    public function getDescricao(): string 
    {
        return $this->descricao;
    }

    public function getStatus(): int 
    {
        return $this->status;
    }

    // setters
    public function setIdSetor($IdSetor) 
    {
        if (!is_null($IdSetor) && (!is_int($IdSetor) || $IdSetor <= 0)) {
            throw new InvalidArgumentException("ID do Setor deve ser inteiro positivo ou nulo.");
        }
        $this->id_setor = $IdSetor;
    }

    public function setDescricao($descricao) 
    {
        if (!is_string($descricao) || trim($descricao) === '' || mb_strlen(trim($descricao)) > 50) {
            throw new InvalidArgumentException("Descrição do Setor inválido ou excede 50 caracteres.");
        }
        $this->descricao = $descricao;
    }

    public function setStatus($Status) 
    {
        if (!is_int($Status) || !in_array($Status, [0, 1], true)) {
            throw new InvalidArgumentException("Status deve ser 0 (inativo) ou 1 (ativo).");
        }
        $this->status = $Status;
    }
}