<?php

    if (!isset($_SESSION)) {
        session_start();
    }

    if (!isset($_SESSION['id_usuario'])) {
        die("Você não pode acessar esta página porque não está logado.<p><a href=\"../view/login.html\">Login</a></p>");
    }
?>