<?php

class LoginController extends BaseController
{
    public function formularioLogin(array $mensagens = []):void
    {
        if (isset($_GET['msg']) && $_GET['msg'] === 'login_required') {
            $mensagens['erroLogin'] = "É necessário estar logado para acessar o sistema.";
        }
        $this->loadView('login.login', [
            'mensagens' => $mensagens
        ]);
    }

    public function validarLogin():void
    {
        try {
            $dados = [
                'email' => $_POST['email'] ?? '',
                'senha' => $_POST['senha'] ?? ''
            ];

            $loginModel = new LoginModel();
            $loginValidador = new LoginValidador($loginModel);
            $loginValidador->validarCampos($dados);
            $usuario = $loginModel->buscarUsuario($dados);

            if ($usuario) {
                Sessao::criarSessao($usuario);
                header("Location: " . BASE_URL);
            } else {
                throw new Exception("Falha ao logar! E-mail ou Senha incorretos.");
            }
        } catch (Throwable $e) {
            $this->formularioLogin(['erroLogin' => $e->getMessage()]); 
        } 
    }
}
