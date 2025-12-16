<?php

class SetorModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarSetoresAtivos():array
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

    public function buscarPorId(int $idSetor):array
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
            throw new Exception("Setor não encontrado.");
        }

        return $resultado;
    }

    public function buscarTodas():array
    {
        $sqlBusca = "SELECT id_setor, descricao, status 
                        FROM setores 
                        ORDER BY id_setor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function registrar(Setor $setor):bool
    {
        try {
            $sqlInsertSetor = "INSERT INTO setores(descricao, status)
                                    VALUES(:descricao, :status);";
            $stmt = $this->pdo->prepare($sqlInsertSetor);
            $stmt->bindValue(':descricao', $setor->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(':status', $setor->getStatus(), PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    public function alterar(Setor $setor):bool
    {
        try {
            $sqlUpdateSetor = "UPDATE setores
                                    SET descricao = :descricao
                                    WHERE id_setor = :idSetor;";
            $stmt = $this->pdo->prepare($sqlUpdateSetor);
            $stmt->bindValue(':descricao', $setor->getDescricao(), PDO::PARAM_STR);
            $stmt->bindValue(':idSetor', $setor->getIdSetor(), PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (Throwable $e) {
            throw $e;
        }
    }

    // Não é permitido excluir Setores que possuem vinculo com Perguntas, Avaliações ou Dispositivos
    public function excluir(int $idSetor):int
    {
        try {
            if($this->setorEmPerguntas($idSetor)) {
                throw new Exception("O Setor possui relacionamento com Perguntas, não será possível realizar a exclusão.");
            } else if($this->setorEmAvaliacoes($idSetor)) {
                throw new Exception("O Setor possui relacionamento com Avaliações, não será possível realizar a exclusão.");
            } else if($this->setorEmDispositivos($idSetor)) {
                throw new Exception("O Setor possui relacionamento com Dispositivos, não será possível realizar a exclusão.");
            }

            //Deletar Setor
            $sqlDeleteSetor = "DELETE FROM setores
                                    WHERE id_setor = :idSetor;";
            $stmt = $this->pdo->prepare($sqlDeleteSetor);
            $stmt->execute([
                'idSetor' => $idSetor,
            ]);

            return $stmt->rowCount();
        } catch (Throwable $e) {
            throw $e;
        }
    }

    private function setorEmPerguntas(int $idSetor):bool 
    {
        $sqlBusca = "SELECT 1 as total
                        FROM pergunta_setor
                        WHERE id_setor = :idSetor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idSetor' => $idSetor
        ]);
        $resultado = $stmt->fetch();

        return $resultado ? true : false;
    }

    private function setorEmAvaliacoes(int $idSetor):bool 
    {
        $sqlBusca = "SELECT 1 as total
                        FROM avaliacoes
                        WHERE id_setor = :idSetor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idSetor' => $idSetor
        ]);
        $resultado = $stmt->fetch();
        
        return $resultado ? true : false;
    }

    private function setorEmDispositivos(int $idSetor):bool 
    {
        $sqlBusca = "SELECT 1 as total
                        FROM dispositivos
                        WHERE id_setor = :idSetor;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idSetor' => $idSetor
        ]);
        $resultado = $stmt->fetch();
        
        return $resultado ? true : false;
    }

    // Verifica se existe um Setor cadastrado com a descrição informada. Usado para validação de duplicidade no cadastro e alteração
    public function existeSetorComDescricao(Setor $setor):mixed
    {
        try {
            $sqlBusca = "SELECT id_setor 
                            FROM setores
                            WHERE descricao = :descricao;";
            $stmt = $this->pdo->prepare($sqlBusca);
            $stmt->bindValue(':descricao', $setor->getDescricao(), PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch();

            return $resultado;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}