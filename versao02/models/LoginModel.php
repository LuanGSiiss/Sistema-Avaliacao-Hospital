<?php

class LoginModel extends Database
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = $this->getConnection();
    }

    public function buscarUsuario(array $dados):mixed
    {
        try {
            $sqlBuscaUsuario = "SELECT id_usuario, email, nome 
                                    FROM usuarios
                                    WHERE email = :email 
                                    AND senha = :senha;";
            $stmt = $this->pdo->prepare($sqlBuscaUsuario);
            $stmt->execute([
                'email' => $dados['email'], 
                'senha' => $dados['senha']
            ]);
            $usuario = $stmt->fetch();

            return $usuario;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}