<?php
    require_once('config.php');

    function registraAvalicao($setor, $id_pergunta, $id_dispositivo, $nota, $feedback, $datahora) {
        try {
            $dbconn = pg_connect("host=$db_HOST dbname=$db_NAME user=$db_USER password=$db_PASSWORD");
            if($dbconn) {
                
                $query = "INSERT INTO avaliacoes(id_setor, id_pergunta, id_dispositivo, resposta, feedback_textual, horario) 
                            VALUES ($setor, $id_pergunta, $id_dispositivo, $nota, '$feedback', '$datahora');";

                $result = pg_query($dbconn, $query);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function buscarPergunta() {
        try {
            $dbconn = pg_connect(getStringConn());
            if($dbconn) {
                
                $query = "SELECT * FROM perguntas WHERE status = true ORDER BY RANDOM() LIMIT 1;";

                $result = pg_query($dbconn, $query);

                $pergunta = pg_fetch_assoc($result);
                
                return $pergunta;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

?>