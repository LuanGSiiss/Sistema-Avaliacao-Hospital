<?php

class Dispositivo
{
    private ?int $id_dispositivo;
    private int $id_setor;
    private string $codigo_identificador;
    private string $nome;
    private int  $status;

    public function __construct(?int $id_dispositivo, int $id_setor, string $codigo_identificador, string $nome, int $situacao = 1) {
        $this->setIdDispositivo($id_dispositivo);
        $this->setIdSetor($id_setor);
        $this->setCodigoIdentificador($codigo_identificador);
        $this->setNome($nome);
        $this->setStatus($situacao);
    }

    public function getIdDispositivo(): int 
    {
        return $this->id_dispositivo;
    }
    public function getIdSetor(): int 
    {
        return $this->id_setor;
    }

    public function getCodigoIdentificador(): string 
    {
        return $this->codigo_identificador;
    }

    public function getNome(): string 
    {
        return $this->nome;
    }

    public function getStatus(): int 
    {
        return $this->status;
    }

    // setters
    public function setIdDispositivo($IdDispositivo) 
    {
        if (!is_null($IdDispositivo) && (!is_int($IdDispositivo) || $IdDispositivo <= 0)) {
            throw new InvalidArgumentException("ID do Dispositivo deve ser inteiro positivo ou nulo.");
        }
        $this->id_dispositivo = $IdDispositivo;
    }
    public function setIdSetor($IdSetor) 
    {
        if (!is_null($IdSetor) && (!is_int($IdSetor) || $IdSetor <= 0)) {
            throw new InvalidArgumentException("ID do Setor deve ser inteiro positivo ou nulo.");
        }
        $this->id_setor = $IdSetor;
    }

    public function setCodigoIdentificador($codigoIdentificador) 
    {
        if (!is_string($codigoIdentificador) || trim($codigoIdentificador) === '' || mb_strlen(trim($codigoIdentificador)) > 7) {
            throw new InvalidArgumentException("Código Identificador inválido ou excede 7 caracteres.");
        }
        $this->codigo_identificador = $codigoIdentificador;
    }
    public function setNome($nome) 
    {
        if (!is_string($nome) || trim($nome) === '' || mb_strlen(trim($nome)) > 50) {
            throw new InvalidArgumentException("Nome do Dispositivo inválido ou excede 50 caracteres.");
        }
        $this->nome = $nome;
    }

    public function setStatus($Status) 
    {
        if (!is_int($Status) || !in_array($Status, [0, 1], true)) {
            throw new InvalidArgumentException("Status deve ser 0 (inativo) ou 1 (ativo).");
        }
        $this->status = $Status;
    }
}