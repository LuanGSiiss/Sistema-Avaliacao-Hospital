<?php
    require_once('model.php');

    $resultado = consultaPerguntas();

    if (pg_num_rows($resultado) > 0) {
        $arrayPerguntas = ["perguntas"=>[]];
        while ($row = pg_fetch_assoc($resultado)) {
            $pergunta = [
                "id_avaliacao"=>$row['id_avaliacao'], 
                "id_setor"=>$row['id_setor'], 
                "id_pergunta"=>$row['id_pergunta'], 
                "id_dispositivo"=>$row['id_dispositivo'], 
                "resposta"=>$row['resposta'], 
                "feedback_textual"=>$row['feedback_textual'], 
                "horario"=>$row['horario'] ];
            array_push($arrayPerguntas['perguntas'], $pergunta);    
            }
        $jsonstring = json_encode($arrayPerguntas);

        echo $jsonstring;

    } else {
        echo "{}";
    }

?>