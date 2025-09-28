<?php

class DispositivoModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
        
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
    }

    public function buscarPorId(int $idDispositivo): array
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

    public function BuscarTodas(): array
    {
        $sqlBusca = "SELECT id_dispositivo, id_setor, codigo_identificador, nome, status 
                        FROM dispositivos 
                        ORDER BY id_dispositivo;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function registrar(Dispositivo $dispositivo): int
    {
        try {
            $sqlInsertDispositivo = "INSERT INTO dispositivos(id_setor, codigo_identificador, nome, status)
                                    VALUES(:idSetor, :codigoIdentificador, :nome, :status);";

            $stmt1 = $this->pdo->prepare($sqlInsertDispositivo);
            $stmt1->bindValue(':idSetor', $dispositivo->getIdSetor(), PDO::PARAM_INT);
            $stmt1->bindValue(':codigoIdentificador', $dispositivo->getCodigoIdentificador(), PDO::PARAM_STR);
            $stmt1->bindValue(':nome', $dispositivo->getNome(), PDO::PARAM_STR);
            $stmt1->bindValue(':status', $dispositivo->getStatus(), PDO::PARAM_INT);
            $stmt1->execute();

            return true;
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function alterar(Dispositivo $dispositivo): int
    {
        try {
            $sqlUpdateDispositivo = "UPDATE dispositivos
                                    SET id_setor = :idSetor,
                                    codigo_identificador = :codigoIdentificador,
                                    nome = :nome
                                    WHERE id_dispositivo = :idDispositivo;";

            $stmt1 = $this->pdo->prepare($sqlUpdateDispositivo);
            
            $stmt1->bindValue(':idDispositivo', $dispositivo->getIdDispositivo(), PDO::PARAM_INT);
            $stmt1->bindValue(':idSetor', $dispositivo->getIdSetor(), PDO::PARAM_INT);
            $stmt1->bindValue(':codigoIdentificador', $dispositivo->getCodigoIdentificador(), PDO::PARAM_STR);
            $stmt1->bindValue(':nome', $dispositivo->getNome(), PDO::PARAM_STR);
            $stmt1->execute();

            return true;
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function excluir(int $idDispositivo): int
    {
        try {
            $sqlDispositivoEmAvaliacoes = "SELECT count(*) as total
                                            FROM avaliacoes
                                            WHERE id_dispositivo = :idDispositivo;";
            $stmt1 = $this->pdo->prepare($sqlDispositivoEmAvaliacoes);
            $stmt1->execute([
                'idDispositivo' => $idDispositivo
            ]);
            
            $resultadoDispositivoEmAvaliacoes = $stmt1->fetch();

            if($resultadoDispositivoEmAvaliacoes['total'] > 0) {
                throw new Exception("O Dispositivo possui relacionamento com avaliações, não será possível realizar a exclusão.");
            }

            //Deletar Dispositivo
            $sqlDeleteDispositivo = "DELETE FROM dispositivos
                                    WHERE id_dispositivo = :idDispositivo;";
            $stmt2 = $this->pdo->prepare($sqlDeleteDispositivo);
            $stmt2->execute([
                'idDispositivo' => $idDispositivo,
            ]);

            return $stmt2->rowCount();
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function validarDuplicacao(Dispositivo $dispositivo, bool $alteracao = false) {
        try {
            $sqlBuscaRegistro = "SELECT id_dispositivo FROM dispositivos
                                    WHERE codigo_identificador = :codigoIdentificador
                                    OR nome = :nome;";

            $stmt1 = $this->pdo->prepare($sqlBuscaRegistro);
            $stmt1->bindValue(':codigoIdentificador', $dispositivo->getCodigoIdentificador(), PDO::PARAM_STR);
            $stmt1->bindValue(':nome', $dispositivo->getNome(), PDO::PARAM_STR);
            $stmt1->execute();

            $resultado = $stmt1->fetch();
            if ($alteracao) {
                return $resultado['id_dispositivo'] === $dispositivo->getIdDispositivo() ? false : true;
            }
            return $resultado ? true : false;
            
        } catch (Throwable $e) {
            throw $e;
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

        return true;
    }
}