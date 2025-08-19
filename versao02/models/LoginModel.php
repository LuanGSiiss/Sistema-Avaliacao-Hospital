<?php

class LoginModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
        
        if (!$this->pdo) {
            throw new Exception("Erro ao conectar com o banco de dados.");
        }
    }

    public function buscaUsuario(array $dados)
    {
        try {
            $sqlBuscaUsuario = "SELECT id_usuario, email, nome 
                                    FROM usuarios
                                    WHERE email = :email AND senha = :senha;";
            $stmt = $this->pdo->prepare($sqlBuscaUsuario);
            $stmt->execute([
                'email' => $dados['email'], 
                'senha' => $dados['senha']
            ]);
            $usuario = $stmt->fetch();

            return $usuario ? $usuario : false;
            
        } catch (Throwable $e) {
            throw $e;
        }
    }
}