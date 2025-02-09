<?php
    require_once 'conexaoPg.php';

    function registraPergunta($texto_pergunta) {
        try {
            $pdo = getConexao();
            if($pdo) {
                
                $sql = "INSERT INTO perguntas(texto_pergunta) VALUES(:texto_pergunta);";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':texto_pergunta'=> $texto_pergunta
                ]);
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>