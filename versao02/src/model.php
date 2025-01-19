<?php
    require_once('config.php');

    function registraAvalicao($setor, $id_pergunta, $id_dispositivo, $nota, $feedback, $datahora) {
        try {
            $dbconn = pg_connect(getStringConn());
            if($dbconn) {
                
                $query = "INSERT INTO avaliacoes(id_setor, id_pergunta, id_dispositivo, resposta, feedback_textual, horario) 
                            VALUES ($setor, $id_pergunta, $id_dispositivo, $nota, '$feedback', '$datahora');";

                $result = pg_query($dbconn, $query);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    function registraPergunta($texto_pergunta) {
        try {
            $dbconn = pg_connect(getStringConn());
            if($dbconn) {
                
                $query = "INSERT INTO perguntas(texto_pergunta) VALUES('$texto_pergunta');";

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

    function consultaPerguntas() {
        try {
            $dbconn = pg_connect(getStringConn());
            if($dbconn) {
            
                $query = "SELECT * FROM avaliacoes ORDER BY id_avaliacao;";
                $result = pg_query($dbconn, $query);
            
                return $result;
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    
        pg_close($dbconn);
    }
    
?>