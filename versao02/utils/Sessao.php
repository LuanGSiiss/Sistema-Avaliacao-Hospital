<?php

class Sessao extends Database
{
    private static function iniciarSessao():void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function criarSessao($usuario):void
    {
        session_set_cookie_params([
            'lifetime' => 0,
            'httponly' => true,
        ]);
        self::iniciarSessao();

        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['logado'] = true;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        session_regenerate_id(true);
    }
    
    public static function validarSessao():void
    {
        try {
            self::iniciarSessao();
            
            if (!isset($_SESSION['logado']) || $_SESSION['logado'] === false) {
                header("Location: " . BASE_URL . "login?msg=login_required");
                exit;
            }

        } catch (Throwable $e) {
            error_log("Erro na validação da sessão: " . $e->getMessage());
            header("Location: " . BASE_URL . "login?msg=login_required");
            exit;
        }
    }

    public static function destruirSessao():void
    {
        self::iniciarSessao();
        session_unset();
        session_destroy();
    }
}
