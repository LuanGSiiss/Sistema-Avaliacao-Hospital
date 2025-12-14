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

    public function buscarSetoresAtivos(): array
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
            $sqlSetorEmPerguntas = "SELECT 1 as total
                                            FROM pergunta_setor
                                            WHERE id_setor = :idSetor;";
            $stmt1 = $this->pdo->prepare($sqlSetorEmPerguntas);
            $stmt1->execute([
                'idSetor' => $idSetor
            ]);
            $resultadoSetorEmPerguntas = $stmt1->fetch();

            $sqlSetorEmAvaliacoes = "SELECT 1 as total
                                            FROM avaliacoes
                                            WHERE id_setor = :idSetor;";
            $stmt2 = $this->pdo->prepare($sqlSetorEmAvaliacoes);
            $stmt2->execute([
                'idSetor' => $idSetor
            ]);
            $resultadoSetorEmAvaliacoes = $stmt2->fetch();

            if(isset($resultadoSetorEmPerguntas['total'])) {
                throw new Exception("O Setor possui relacionamento com Perguntas, não será possível realizar a exclusão.");
            } elseif(isset($resultadoSetorEmAvaliacoes['total'])) {
                throw new Exception("O Setor possui relacionamento com Avaliações, não será possível realizar a exclusão.");
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

    public function validarDuplicidade(Setor $setor, bool $alteracao = false) {
        try {
            $sqlBuscaRegistro = "SELECT id_setor FROM setores
                                    WHERE descricao = :descricao;";

            $stmt1 = $this->pdo->prepare($sqlBuscaRegistro);
            $stmt1->bindValue(':descricao', $setor->getDescricao(), PDO::PARAM_STR);
            $stmt1->execute();

            $resultado = $stmt1->fetch();
            $duplicado = $resultado ? true : false; 

            if ($alteracao && $duplicado && $resultado['id_setor'] === $setor->getIdSetor()) {
                $duplicado = false;
            }

            if ($duplicado) {
                throw new Exception("Já existe um Setor cadastro com essa Descrição.");
            }

            return false;
            
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function validarCampos(array $dados, bool $alteracao = false) 
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

        return true;
    }
}