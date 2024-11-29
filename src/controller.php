<?php
    $nota = $_POST['nota'];
    $feedback = $_POST['feedback'];
    date_default_timezone_set('America/Sao_Paulo');
    $datahora = date('Y-m-d H:i:s');
    echo 'Aqui está' . $nota . ' E ' . $feedback . ' alem ' . $datahora;

?>