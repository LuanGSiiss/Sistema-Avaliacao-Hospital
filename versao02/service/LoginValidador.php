<?php

class LoginValidador 
{
    private LoginModel $loginModel;

    public function __construct(LoginModel $loginModel) 
    {
        $this->loginModel = $loginModel;
    }

    public function validarCampos(array $dados) 
    {
        // Email
        if (!is_string($dados['email']) || trim($dados['email']) === '' || mb_strlen(trim($dados['email'])) > 50) {
            throw new Exception("Email inválido ou excede 50 caracteres.");
        } 
        
        // Senha
        if (!is_string($dados['senha']) || trim($dados['senha']) === '' || mb_strlen(trim($dados['senha'])) > 50) {
            throw new Exception("Senha inválida ou excede 50 caracteres.");
        }
    }
}