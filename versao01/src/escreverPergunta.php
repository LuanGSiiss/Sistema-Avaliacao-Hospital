<?php

    require_once('model.php');
    
    function escreverPergunta() {
        $pergunta = buscarPergunta();

        $retornohtml = '<p class="pergunta">' . $pergunta['texto_pergunta'] . '</p>' . 
                        '<input type="hidden" value="'. $pergunta['id_pergunta'] . '" name="id_pergunta">';

        echo $retornohtml;
    }

?>