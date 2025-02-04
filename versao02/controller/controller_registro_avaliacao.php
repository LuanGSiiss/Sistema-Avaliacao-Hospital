<?php

    require_once('../model/model.php');

    // setor = 1
    // id_disposito = 1
    $nota = $_POST['nota'];
    $feedback = $_POST['feedback'];
    $id_pergunta = $_POST['id_pergunta'];
    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');

    registraAvalicao(1, $id_pergunta, 1, $nota, $feedback, $datahora);

    header('Location: ../view/agradecimento.html');
    exit;
?>