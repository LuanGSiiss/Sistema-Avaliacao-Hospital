<?php
    require_once "../model/model_login.php";
    
    if (isset($_POST['email']) && isset($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        
        $usuario = validarLogin($email, $senha);

        if ($usuario) {

            session_start();

            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['usuario'] = $usuario['usuario'];

            header("Location: ../view/homeSelecao.php");
            exit;
        } else {
            echo "Falha ao logar! E-mail ou senha incorretos";
        }
    } else {
        echo "Necessário informar Email e Senha";
    }
?>