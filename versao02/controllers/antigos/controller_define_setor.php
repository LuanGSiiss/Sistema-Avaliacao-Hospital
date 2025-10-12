<?php 
    require_once('../model/model_define_setor.php');

    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_REQUEST['id_setor'])) {
        $setor = $_REQUEST['id_setor'];
        if (validarSetor($setor)) {
            $_SESSION['id_setor'] = $setor;
        }
        header("Location: ../view/paginaAvaliacao.php");
    } else {
        return die('Setor não existe');
    }
?>