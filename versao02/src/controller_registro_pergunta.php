<?php
    require_once('model.php');

    header('Content-Type: application/json');

    $texto_pergunta = $_POST['texto_pergunta'] ?? null;

    if ($texto_pergunta == null) {
        http_response_code(402);
        echo json_encode([
            "status" => "error",
            "mensagem" => "Pergunta não pode ser vazia"
        ]);
    }
    else if ($texto_pergunta) {
        registraPergunta($texto_pergunta);
        
        echo json_encode([
            "status" => "sucesso",
            "mensagem" => "Pergunta cadastrada com sucesso"
        ]);
    } else {
        http_response_code(403);
        echo json_encode([
            "status" => "error",
            "mensagem" => "Os dados não foram enviados corretamente"
        ]);
    }
?>