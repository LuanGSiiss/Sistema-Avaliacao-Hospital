<?php
    require_once('../model/model_homeSelecao.php');

    $resultado = consultaSetores();

    if (sizeof($resultado) > 0) {
        $arraySetores = ["setores"=>[]];
        foreach ($resultado as $registro) {
            $setor = [
                $registro['id_setor'], 
                $registro['descricao'] 
            ];
            array_push($arraySetores['setores'], $setor);
        }
        $jsonstring = json_encode($arraySetores);
        echo $jsonstring;
    } else {
        echo "{}";
    }

?>