<?php
    require_once('model.php');

    header('Content-Type: application/json');

    $texto_pergunta = $_POST['texto_pergunta'] ?? NULL;

    if($texto_pergunta) {

    } else if ($texto_pergunta = '') {
        registraPergunta($texto_pergunta);
        
        echo json_encode([
            "status" => "sucesso",
            "mensagem" => "Dados recebidos com sucesso!"
        ]);
    } else {
        echo json_encode([
            "status" => "erro",
            "mensagem" => "Os dados não foram enviados corretamente"
        ]);
    }
?>