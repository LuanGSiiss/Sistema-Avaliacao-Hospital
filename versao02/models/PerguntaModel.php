<?php

class PerguntaModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarPerguntaAleatoriaPorSetor(int $idSetor):?array
    {
        $sqlBusca = "SELECT p.id_pergunta, p.texto_pergunta 
                        FROM perguntas p
                        LEFT JOIN pergunta_setor ps USING(id_pergunta)
                        LEFT JOIN setores s USING(id_setor)
                        WHERE p.status = 1 
                        AND ( p.todos_setores = true OR ps.id_setor = :idSetor AND s.status = 1)
                        ORDER BY RANDOM()
                        LIMIT 1;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idSetor' => $idSetor
        ]);
        $resultado = $stmt->fetch();

        return $resultado ?: null;
    }

    public function buscarPorId(int $idPergunta):array
    {
        $sqlBusca = "SELECT id_pergunta, texto_pergunta, todos_setores, status 
                        FROM perguntas
                        WHERE id_pergunta = :idPergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idPergunta' => $idPergunta
        ]);
        $resultado = $stmt->fetch();

        if($resultado === false) {
            throw new Exception("Pergunta não encontrada.");
        }

        return $resultado;
    }

    public function buscarTodas(): array
    {
        $sqlBusca = "SELECT id_pergunta, texto_pergunta, todos_setores, status 
                        FROM perguntas 
                        ORDER BY id_pergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function buscarSetoresPorPergunta(int $idPergunta):array
    {
        $sqlBusca = "SELECT id_setor 
                        FROM pergunta_setor
                        WHERE id_pergunta = :idPergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idPergunta' => $idPergunta
        ]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function registrar(Pergunta $pergunta, array $setores):bool
    {
        try {
            $this->pdo->beginTransaction();

            $sqlInsertPergunta = "INSERT INTO perguntas(texto_pergunta, todos_setores, status)
                                    VALUES(:textoPergunta, :todosSetores, :status);";
            $stmt = $this->pdo->prepare($sqlInsertPergunta);
            $stmt->bindValue(':textoPergunta', $pergunta->getTextoPergunta(), PDO::PARAM_STR);
            $stmt->bindValue(':todosSetores', $pergunta->getTodosSetores(), PDO::PARAM_BOOL);
            $stmt->bindValue(':status', $pergunta->getStatus(), PDO::PARAM_INT);
            $stmt->execute();

            $idPerguntaRegistrada = $this->pdo->lastInsertId();

            // Cadastrar a relação de Setor e Pergunta
            if (!$pergunta->getTodosSetores()) {
                if (empty($setores)) {
                    throw new Exception("Setores não informados.");
                }

                $this->relacionarSetores($idPerguntaRegistrada, $setores);
            }

            $this->pdo->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    public function alterar(Pergunta $pergunta, array $setores):bool
    {
        try {
            $this->pdo->beginTransaction();

            $sqlUpdatePergunta = "UPDATE perguntas
                                    SET texto_pergunta = :textoPergunta,
                                        todos_setores = :todosSetores
                                    WHERE id_pergunta = :idPergunta;";
            $stmt1 = $this->pdo->prepare($sqlUpdatePergunta);
            $stmt1->bindValue(':textoPergunta', $pergunta->getTextoPergunta(), PDO::PARAM_STR);
            $stmt1->bindValue(':todosSetores', $pergunta->getTodosSetores(), PDO::PARAM_BOOL);
            $stmt1->bindValue(':idPergunta', $pergunta->getIdPergunta(), PDO::PARAM_INT);
            $stmt1->execute();

            $this->excluirRelacionamentoSetores($pergunta->getIdPergunta());

            if (!$pergunta->getTodosSetores()) {
                if (empty($setores)) {
                    throw new Exception("Setores não informados.");
                }

                $this->relacionarSetores($pergunta->getIdPergunta(), $setores);
            }

            $this->pdo->commit();
            return true;
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    // Não é permitido excluir Perguntas que possuem vinculo com Avaliações
    public function excluir(int $idPergunta):int
    {
        try {
            if($this->perguntaEmAvaliacoes($idPergunta)) {
                throw new Exception("A pergunta possui relacionamento com avaliações, não será possível realizar a exclusão.");
            }

            $this->pdo->beginTransaction();

            $this->excluirRelacionamentoSetores($idPergunta);

            $sqlDeletePergunta = "DELETE FROM perguntas
                                    WHERE id_pergunta = :idPergunta;";
            $stmt = $this->pdo->prepare($sqlDeletePergunta);
            $stmt->execute([
                'idPergunta' => $idPergunta,
            ]);

            $this->pdo->commit();
            
            return $stmt->rowCount();
        } catch (Throwable $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    private function relacionarSetores(int $idPergunta, array $setores):void 
    {
        foreach ($setores as $setor) {
            $sqlInsertPerguntaSetores = "INSERT INTO pergunta_setor(id_pergunta, id_setor)
                                            VALUES(:idPergunta, :idSetor);";
            $stmt = $this->pdo->prepare($sqlInsertPerguntaSetores);
            $stmt->execute([
                'idPergunta' => $idPergunta,
                'idSetor'    => $setor
            ]);
        }
    }

    private function excluirRelacionamentoSetores(int $idPergunta):void 
    {
        $sqlDelete = "DELETE FROM pergunta_setor
                        WHERE id_pergunta = :idPergunta;";
        $stmt = $this->pdo->prepare($sqlDelete);
        $stmt->execute([
            'idPergunta' => $idPergunta,
        ]);
    }

    private function perguntaEmAvaliacoes(int $idPergunta):bool 
    {
        $sqlBusca = "SELECT 1 as total
                        FROM avaliacoes
                        WHERE id_pergunta = :idPergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'idPergunta' => $idPergunta
        ]);
        $resultado = $stmt->fetch();

        return $resultado ? true : false;
    }

    // Verifica se existe uma Pergunta cadastrada com o texto informado. Usado para validação de duplicidade no cadastro e alteração
    public function existePerguntaComTexto(Pergunta $pergunta):mixed
    {
        try {
            $sqlBusca = "SELECT id_pergunta 
                            FROM perguntas
                            WHERE texto_pergunta = :textoPergunta;";
            $stmt = $this->pdo->prepare($sqlBusca);
            $stmt->bindValue(':textoPergunta', $pergunta->getTextoPergunta(), PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch();

            return $resultado;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}