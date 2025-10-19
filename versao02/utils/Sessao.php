<?php

class Sessao extends Database
{
    private static function iniciarSessao(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    public static function  criarSessao($usuario): bool
    {
        session_set_cookie_params([
            'lifetime' => 0,
            'httponly' => true,
            'secure'   => true, 
            'samesite' => 'Strict'
        ]);
        self::iniciarSessao();

        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome'];
        $_SESSION['logado'] = true;
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

        session_regenerate_id(true);
        return true;
    }
    
    public static function  validarSessao(): bool
    {
        try {
            self::iniciarSessao();
            
            if (!isset($_SESSION['logado']) || $_SESSION['logado'] === false) {
                header("Location: " . BASE_URL . "login?msg=login_required");
                exit;
            }

            return true;
        } catch (Throwable $e) {
            error_log("Erro na validação de sessão: " . $e->getMessage());
            header("Location: " . BASE_URL . "login?msg=login_required");
            exit;
        }
    }
    public static function  destruirSessao(): void
    {
        self::iniciarSessao();
        session_unset();
        session_destroy();
    }
}
?>