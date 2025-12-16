<?php

class DispositivoModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarPorId(int $idDispositivo):array
    {
        $sqlBusca = "SELECT id_dispositivo, id_setor, codigo_identificador, nome, status 
                        FROM dispositivos
                        WHERE id_dispositivo = :idDispositivo;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idDispositivo' => $idDispositivo
        ]);
        $resultado = $stmt->fetch();

        if($resultado === false) {
            throw new Exception("Dispositivo não encontrado.");
        }

        return $resultado;
    }

    public function buscarTodas():array
    {
        $sqlBusca = "SELECT id_dispositivo, id_setor, codigo_identificador, nome, status 
                        FROM dispositivos 
                        ORDER BY id_dispositivo;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function registrar(Dispositivo $dispositivo):bool
    {
        try {
            $sqlInsertDispositivo = "INSERT INTO dispositivos(id_setor, codigo_identificador, nome, status)
                                    VALUES(:idSetor, :codigoIdentificador, :nome, :status);";
            $stmt = $this->pdo->prepare($sqlInsertDispositivo);
            $stmt->bindValue(':idSetor', $dispositivo->getIdSetor(), PDO::PARAM_INT);
            $stmt->bindValue(':codigoIdentificador', $dispositivo->getCodigoIdentificador(), PDO::PARAM_STR);
            $stmt->bindValue(':nome', $dispositivo->getNome(), PDO::PARAM_STR);
            $stmt->bindValue(':status', $dispositivo->getStatus(), PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function alterar(Dispositivo $dispositivo):bool
    {
        try {
            $sqlUpdateDispositivo = "UPDATE dispositivos
                                        SET id_setor = :idSetor,
                                            codigo_identificador = :codigoIdentificador,
                                            nome = :nome
                                        WHERE id_dispositivo = :idDispositivo;";
            $stmt = $this->pdo->prepare($sqlUpdateDispositivo);
            $stmt->bindValue(':idDispositivo', $dispositivo->getIdDispositivo(), PDO::PARAM_INT);
            $stmt->bindValue(':idSetor', $dispositivo->getIdSetor(), PDO::PARAM_INT);
            $stmt->bindValue(':codigoIdentificador', $dispositivo->getCodigoIdentificador(), PDO::PARAM_STR);
            $stmt->bindValue(':nome', $dispositivo->getNome(), PDO::PARAM_STR);
            $stmt->execute();

            return true;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    // Não é permitido excluir Dispositivos que possuem vinculo com Avaliações
    public function excluir(int $idDispositivo):int
    {
        try {
            if($this->dispositivoEmAvaliacoes($idDispositivo)) {
                throw new Exception("O Dispositivo possui relacionamento com avaliações, não será possível realizar a exclusão.");
            }

            $sqlDeleteDispositivo = "DELETE FROM dispositivos
                                        WHERE id_dispositivo = :idDispositivo;";
            $stmt = $this->pdo->prepare($sqlDeleteDispositivo);
            $stmt->execute([
                'idDispositivo' => $idDispositivo,
            ]);

            return $stmt->rowCount();
        } catch (Throwable $e) {
            throw $e;
        }
    }

    private function dispositivoEmAvaliacoes(int $idDispositivo):bool 
    {
        $sqlBusca = "SELECT 1 as total
                        FROM avaliacoes
                        WHERE id_dispositivo = :idDispositivo;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idDispositivo' => $idDispositivo
        ]);
        $resultado = $stmt->fetch();

        return $resultado ? true : false;
    }

    // Verifica se existe um Dispositivo cadastrado com o nome informado. Usado para validação de duplicidade no cadastro e alteração
    public function existeDispositivoComNome(Dispositivo $dispositivo):mixed
    {
        try {
            $sqlBusca = "SELECT id_dispositivo 
                            FROM dispositivos
                            WHERE nome = :nome;";
            $stmt = $this->pdo->prepare($sqlBusca);
            $stmt->bindValue(':nome', $dispositivo->getNome(), PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch();

            return $resultado;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    // Verifica se existe um Dispositivo cadastrado com o código identificador informado. Usado para validação de duplicidade no cadastro e alteração
    public function existeDispositivoComIdentificador(Dispositivo $dispositivo):mixed
    {
        try {
            $sqlBusca = "SELECT id_dispositivo 
                            FROM dispositivos
                            WHERE codigo_identificador = :codigoIdentificador;";
            $stmt = $this->pdo->prepare($sqlBusca);
            $stmt->bindValue(':codigoIdentificador', $dispositivo->getCodigoIdentificador(), PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch();

            return $resultado;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}