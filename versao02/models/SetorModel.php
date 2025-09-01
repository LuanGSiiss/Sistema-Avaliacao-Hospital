<?php

class SetorModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();

        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
    }

    public function BuscarSetoresAtivos(): array
    {
        $sqlBusca = "SELECT id_setor, descricao
                        FROM setores 
                        WHERE status = 1
                        ORDER BY descricao;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();
        
        return $resultado;
    }

    public function buscarPorId(int $idSetor): array
    {
        $sqlBusca = "SELECT id_setor, descricao, status 
                        FROM setores
                        WHERE id_setor = :idSetor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idSetor' => $idSetor
        ]);
        $resultado = $stmt->fetch();

        if($resultado === false) {
            throw new Exception("Setor não encontrada.");
        }

        return $resultado;
    }

    public function BuscarTodas(): array
    {
        $sqlBusca = "SELECT id_setor, descricao, status 
                        FROM setores 
                        ORDER BY id_setor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function registrar(Setor $setor): int
    {
        try {
            $sqlInsertSetor = "INSERT INTO setores(descricao, status)
                                    VALUES(:descricao, :status);";

            $stmt1 = $this->pdo->prepare($sqlInsertSetor);
            $stmt1->bindValue(':descricao', $setor->getDescricao(), PDO::PARAM_STR);
            $stmt1->bindValue(':status', $setor->getStatus(), PDO::PARAM_INT);
            $stmt1->execute();

            return true;
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function alterar(Setor $setor): int
    {
        try {
            $sqlUpdateSetor = "UPDATE setores
                                    SET descricao = :descricao
                                    WHERE id_setor = :idSetor;";

            $stmt1 = $this->pdo->prepare($sqlUpdateSetor);
            
            $stmt1->bindValue(':descricao', $setor->getDescricao(), PDO::PARAM_STR);
            $stmt1->bindValue(':idSetor', $setor->getIdSetor(), PDO::PARAM_INT);
            $stmt1->execute();

            return true;
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function excluir(int $idSetor): int
    {
        try {
            $sqlSetorEmPerguntas = "SELECT count(*) as total
                                            FROM pergunta_setor
                                            WHERE id_setor = :idSetor;";
            $stmt1 = $this->pdo->prepare($sqlSetorEmPerguntas);
            $stmt1->execute([
                'idSetor' => $idSetor
            ]);
            
            $resultadoSetorEmPerguntas = $stmt1->fetch();

            if($resultadoSetorEmPerguntas['total'] > 0) {
                throw new Exception("O Setor possui relacionamento com Perguntas, não será possível realizar a exclusão.");
            }

            //Deletar Setor
            $sqlDeleteSetor = "DELETE FROM setores
                                    WHERE id_setor = :idSetor;";
            $stmt3 = $this->pdo->prepare($sqlDeleteSetor);
            $stmt3->execute([
                'idSetor' => $idSetor,
            ]);

            return $stmt3->rowCount();
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function validarCamposSetor(array $dados, bool $alteracao = false) 
    {
        // ID
        if($alteracao) {
            if (empty($dados['idSetor']) || !is_int($dados['idSetor']) || $dados['idSetor'] <= 0) {
                throw new Exception("ID do Setor inválido.");
            }
        }

        // Descrição
        $texto = $dados['descricao'] ?? '';
        if (!is_string($texto) || trim($texto) === '' || mb_strlen(trim($texto)) > 50) {
            throw new Exception("Descrição do Setor inválido ou excede 50 caracteres.");
        }

        // status
        if (isset($dados['status']) && (!is_int($dados['status']) || !in_array($dados['status'], [0, 1], true))) {
            throw new Exception("Status deve ser 0 ou 1.");
        }

        return true;
    }
}