<?php
    require_once('../model/model_adm_consulta.php');

    $resultado = consultaPerguntas();

    if (sizeof($resultado) > 0) {
        $arrayPerguntas = ["perguntas"=>[]];
        foreach ($resultado as $registro) {
            $pergunta = [
                "id_avaliacao"=>$registro['id_avaliacao'], 
                "id_setor"=>$registro['id_setor'], 
                "id_pergunta"=>$registro['id_pergunta'], 
                "id_dispositivo"=>$registro['id_dispositivo'], 
                "resposta"=>$registro['resposta'], 
                "feedback_textual"=>$registro['feedback_textual'], 
                "horario"=>$registro['horario'] ];
            array_push($arrayPerguntas['perguntas'], $pergunta);
        }
        $jsonstring = json_encode($arrayPerguntas);
        echo $jsonstring;
    } else {
        echo "{}";
    }

?>