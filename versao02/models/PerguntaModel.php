<?php

class PerguntaModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarPerguntaAleatoriaPorSetor(int $idSetor): ?array
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {
            $sql = "SELECT p.id_pergunta, p.texto_pergunta 
                        FROM perguntas p
                        LEFT JOIN pergunta_setor ps USING(id_pergunta)
                        LEFT JOIN setor s USING(id_setor)
                        WHERE p.status = 1 
                        AND ( p.todos_setores = true OR ps.id_setor = :id_setor AND s.status = 1)
                        ORDER BY RANDOM()
                        LIMIT 1;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id_setor' => $idSetor]);
            
            $resultado = $stmt->fetch();

            return $resultado ?: null;
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }

    public function BuscarTodas()
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {
            $sql = "SELECT id_pergunta, texto_pergunta, todos_setores, status 
                        FROM perguntas 
                        ORDER BY id_pergunta;";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll();
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }

    public function registrar(Pergunta $pergunta, $setores)
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }

        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO perguntas(texto_pergunta, todos_setores, status)
                        VALUES(:texto_pergunta, :todos_setores, :status);";

            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindValue(':texto_pergunta', $pergunta->texto_pergunta, PDO::PARAM_STR);
            $stmt->bindValue(':todos_setores', $pergunta->todos_setores, PDO::PARAM_BOOL);
            $stmt->bindValue(':status', $pergunta->status, PDO::PARAM_INT);
            $stmt->execute();

            $idPerguntaRegistrada = $this->pdo->lastInsertId();

            // Cadastrar a relação de Setor e Pergunta
            if(!$pergunta->todos_setores) {
                if (empty($setores)) {
                    throw new Exception("Setores não informados.");
                }

                foreach ($setores as $setor) {
                    $sql = "INSERT INTO pergunta_setor(id_pergunta, id_setor)
                        VALUES(:id_pergunta, :id_setor);";

                    $stmt = $this->pdo->prepare($sql);
            
                    $stmt->execute([
                        'id_pergunta' => $idPerguntaRegistrada,
                        'id_setor'  => $setor
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Erro na query: " . $e->getMessage());
        }
    }

    public function buscarPeguntaPorId(int $idPergunta)
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {
            $sql = "SELECT id_pergunta, texto_pergunta, todos_setores 
                        FROM perguntas
                        WHERE id_pergunta = :idPergunta;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['idPergunta' => $idPergunta]);
            
            $resultado = $stmt->fetch();

            if($resultado == []) {
                throw new Exception("Pergunta não encontrda.");
            }

            return $resultado;
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }

    public function buscarSetoresPorPergunta(int $idPergunta)
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
        
        try {
            $sql = "SELECT id_setor 
                        FROM pergunta_setor
                        WHERE id_pergunta = :idPergunta;";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['idPergunta' => $idPergunta]);
            
            $resultado = $stmt->fetchAll();

            return $resultado;
            
        } catch (PDOException $e) {
            throw new Exception("Erro na consulta: " . $e->getMessage());
        }
    }

    public function alterar(Pergunta $pergunta, $setores)
    {
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }

        try {
            $this->pdo->beginTransaction();

            $sql = "UPDATE perguntas
                        SET texto_pergunta = :texto_pergunta,
                            todos_setores = :todos_setores
                        WHERE id_pergunta = :id_pergunta;";

            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindValue(':texto_pergunta', $pergunta->texto_pergunta, PDO::PARAM_STR);
            $stmt->bindValue(':todos_setores', $pergunta->todos_setores, PDO::PARAM_BOOL);
            $stmt->bindValue(':id_pergunta', $pergunta->id_pergunta, PDO::PARAM_INT);
            $stmt->execute();

            //Excluir as relações entre Pergunta e Setor
            $sqlDelete = "DELETE FROM pergunta_setor
                            WHERE id_pergunta = :id_pergunta;";

            $stmt = $this->pdo->prepare($sqlDelete);
            
            $stmt->execute([
                'id_pergunta' => $pergunta->id_pergunta,
            ]);

            // Cadastrar as relações de Pergunta e Setor
            if(!$pergunta->todos_setores) {
                if (empty($setores)) {
                    throw new Exception("Setores não informados.");
                }

                foreach ($setores as $setor) {
                    $sql = "INSERT INTO pergunta_setor(id_pergunta, id_setor)
                        VALUES(:id_pergunta, :id_setor);";

                    $stmt = $this->pdo->prepare($sql);
            
                    $stmt->execute([
                        'id_pergunta' => $pergunta->id_pergunta,
                        'id_setor'  => $setor
                    ]);
                }
            }

            $this->pdo->commit();
            return true;
            
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            throw new Exception("Erro na query: " . $e->getMessage());
        }
    }
}