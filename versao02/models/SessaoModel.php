<?php
require_once __DIR__ . '/../utils/config.php';

class SessaoModel extends Database
{
    public static function  validarSessao()
    {
        try {
            if (!isset($_SESSION)) {
                session_start();
            }

            if (!isset($_SESSION['id_usuario'])) {
                die('Você não pode acessar esta página porque não está logado.<p><a href="' . BASE_URL . 'login">Login</a></p>');
            }

            return true;
        } catch (Throwable $e) {
            throw $e;
        }
    }
}
?>