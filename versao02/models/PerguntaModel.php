<?php

class PerguntaModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();

        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
    }

    public function buscarPerguntaAleatoriaPorSetor(int $idSetor): ?array
    {
        $sqlBusca = "SELECT p.id_pergunta, p.texto_pergunta 
                    FROM perguntas p
                    LEFT JOIN pergunta_setor ps USING(id_pergunta)
                    LEFT JOIN setores s USING(id_setor)
                    WHERE p.status = 1 
                    AND ( p.todos_setores = true OR ps.id_setor = :id_setor AND s.status = 1)
                    ORDER BY RANDOM()
                    LIMIT 1;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([
            'id_setor' => $idSetor
        ]);
        $resultado = $stmt->fetch();

        return $resultado ?: null;
    }

    public function buscarPorId(int $idPergunta): array
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

    public function BuscarTodas(): array
    {
        $sqlBusca = "SELECT id_pergunta, texto_pergunta, todos_setores, status 
                        FROM perguntas 
                        ORDER BY id_pergunta;";
        $stmt = $this->pdo->prepare($sqlBusca);
        $stmt->execute([]);
        $resultado = $stmt->fetchAll();

        return $resultado;
    }

    public function buscarSetoresPorPergunta(int $idPergunta): array
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

    public function registrar(Pergunta $pergunta, array $setores): int
    {
        try {
            $this->pdo->beginTransaction();

            $sqlInsertPergunta = "INSERT INTO perguntas(texto_pergunta, todos_setores, status)
                                    VALUES(:texto_pergunta, :todos_setores, :status);";

            $stmt1 = $this->pdo->prepare($sqlInsertPergunta);
            $stmt1->bindValue(':texto_pergunta', $pergunta->getTextoPergunta(), PDO::PARAM_STR);
            $stmt1->bindValue(':todos_setores', $pergunta->getTodosSetores(), PDO::PARAM_BOOL);
            $stmt1->bindValue(':status', $pergunta->getStatus(), PDO::PARAM_INT);
            $stmt1->execute();

            $idPerguntaRegistrada = $this->pdo->lastInsertId();

            // Cadastrar a relação de Setor e Pergunta
            if(!$pergunta->getTodosSetores()) {
                if (empty($setores)) {
                    throw new Exception("Setores não informados.");
                }

                foreach ($setores as $setor) {
                    $sqlInsertPerguntaSetores = "INSERT INTO pergunta_setor(id_pergunta, id_setor)
                                                    VALUES(:id_pergunta, :id_setor);";

                    $stmt2 = $this->pdo->prepare($sqlInsertPerguntaSetores);
                    $stmt2->execute([
                        'id_pergunta' => $idPerguntaRegistrada,
                        'id_setor'  => $setor
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
            
        } catch (Throwable $e) {
            if($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    public function alterar(Pergunta $pergunta, array $setores): int
    {
        try {
            $this->pdo->beginTransaction();

            $sqlUpdatePergunta = "UPDATE perguntas
                                    SET texto_pergunta = :texto_pergunta,
                                    todos_setores = :todos_setores
                                    WHERE id_pergunta = :id_pergunta;";

            $stmt1 = $this->pdo->prepare($sqlUpdatePergunta);
            
            $stmt1->bindValue(':texto_pergunta', $pergunta->getTextoPergunta(), PDO::PARAM_STR);
            $stmt1->bindValue(':todos_setores', $pergunta->getTodosSetores(), PDO::PARAM_BOOL);
            $stmt1->bindValue(':id_pergunta', $pergunta->getIdPergunta(), PDO::PARAM_INT);
            $stmt1->execute();

            //Excluir as relações entre Pergunta e Setor
            $sqlDelete = "DELETE FROM pergunta_setor
                            WHERE id_pergunta = :id_pergunta;";

            $stmt2 = $this->pdo->prepare($sqlDelete);
            $stmt2->execute([
                'id_pergunta' => $pergunta->getIdPergunta(),
            ]);

            // Cadastrar as relações de Pergunta e Setor
            if(!$pergunta->getTodosSetores()) {
                if (empty($setores)) {
                    throw new Exception("Setores não informados.");
                }

                foreach ($setores as $setor) {
                    $sqlInsertPerguntaSetores = "INSERT INTO pergunta_setor(id_pergunta, id_setor)
                                                    VALUES(:id_pergunta, :id_setor);";

                    $stmt3 = $this->pdo->prepare($sqlInsertPerguntaSetores);
                    $stmt3->execute([
                        'id_pergunta' => $pergunta->getIdPergunta(),
                        'id_setor'  => $setor
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
            
        } catch (Throwable $e) {
            if($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            
            throw $e;
        }
    }

    public function excluir(int $idPergunta): int
    {
        try {
            $sqlPerguntaEmAvaliacoes = "SELECT count(*) as total
                                            FROM avaliacoes
                                            WHERE id_pergunta = :idPergunta;";
            $stmt1 = $this->pdo->prepare($sqlPerguntaEmAvaliacoes);
            $stmt1->execute([
                'idPergunta' => $idPergunta
            ]);
            
            $resultadoPerguntaEmAvaliacoes = $stmt1->fetch();

            if($resultadoPerguntaEmAvaliacoes['total'] > 0) {
                throw new Exception("A pergunta possui relacionamento com avaliações, não será possível realizar a exclusão.");
            }
            $this->pdo->beginTransaction();


            //Deletar os relacionamentos de Pergunta e Setor
            $sqlDeletePerguntaSetor = "DELETE FROM pergunta_setor
                                        WHERE id_pergunta = :idPergunta;";
            $stmt2 = $this->pdo->prepare($sqlDeletePerguntaSetor);
            $stmt2->execute([
                'idPergunta' => $idPergunta,
            ]);

            //Deletar Pergunta
            $sqlDeletePergunta = "DELETE FROM perguntas
                                    WHERE id_pergunta = :idPergunta;";
            $stmt3 = $this->pdo->prepare($sqlDeletePergunta);
            $stmt3->execute([
                'idPergunta' => $idPergunta,
            ]);

            $this->pdo->commit();
            return $stmt3->rowCount();
            
        } catch (Throwable $e) {
            if($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            throw $e;
        }
    }

    public function validarCamposPergunta(array $dados, bool $alteracao = false) 
    {
        // ID
        if($alteracao) {
            if (empty($dados['idPergunta']) || !is_int($dados['idPergunta']) || $dados['idPergunta'] <= 0) {
                throw new Exception("ID da pergunta inválido.");
            }
        }

        // Texto da Pergunta
        $texto = $dados['textoPergunta'] ?? '';
        if (!is_string($texto) || trim($texto) === '' || mb_strlen(trim($texto)) > 350) {
            throw new Exception("Texto da pergunta inválido ou excede 350 caracteres.");
        }

        // todosSetores
        if (!isset($dados['todosSetores']) || !is_bool($dados['todosSetores'])) {
            throw new Exception("'todosSetores' deve ser booleano.");
        }

        // setores
        if (!$dados['todosSetores']) {
            if (empty($dados['setores']) || !is_array($dados['setores'])) {
                throw new Exception("Setores obrigatórios quando 'todosSetores' é falso.");
            }
        }

        // status
        if (isset($dados['status']) && (!is_int($dados['status']) || !in_array($dados['status'], [0, 1], true))) {
            throw new Exception("Status deve ser 0 ou 1.");
        }

        return true;
    }
}