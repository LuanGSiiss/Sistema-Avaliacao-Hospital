<?php
require_once __DIR__ . '/../utils/config.php';

class LoginController extends RenderView
{
    public function formularioLogin(array $mensagens = [])
    {
        if (isset($_GET['msg']) && $_GET['msg'] === 'login_required') {
            $mensagens['erroLogin'] = "É necessário estar logado para acessar o sistema.";
        }
        $this->loadView('login.login', [
            'mensagens' => $mensagens
        ]);
    }

    public function validarLogin()
    {
        try {
            $dados = [
                'email' => $_POST['email'] ?? '',
                'senha'  => $_POST['senha'] ?? ''
            ];

            if(!class_exists('LoginModel')) {
                throw new Exception("Classe 'LoginModel' não existe.");
            }
            
            //Valida Parametros
            if (!is_string($dados['email']) || trim($dados['email']) === '' || mb_strlen(trim($dados['email'])) > 50) {
                throw new Exception("Email inválido ou excede 50 caracteres.");
            } elseif (!is_string($dados['senha']) || trim($dados['senha']) === '' || mb_strlen(trim($dados['senha'])) > 50) {
                throw new Exception("Senha inválida ou excede 50 caracteres.");
            }

            $loginModel = new LoginModel();
            $usuario = $loginModel->buscaUsuario($dados);

            if ($usuario) {
                Sessao::criarSessao($usuario);
                header("Location: " . BASE_URL . "consultaPerguntas");
            } else {
                throw new Exception("Falha ao logar! E-mail ou Senha incorretos.");
            }
        } catch (Throwable $e) {
            $this->formularioLogin(['erroLogin' => $e->getMessage()]); 
        } 
    }
}
