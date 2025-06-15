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
}