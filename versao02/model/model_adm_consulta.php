<?php 
    require_once 'conexaoPg.php';

    function consultaPerguntas() {
        try {
            $pdo = getConexao();
            if($pdo) {
            
                $sql = "SELECT * FROM avaliacoes ORDER BY id_avaliacao;";
                $stmt = $pdo->query($sql);
                $resultado = $stmt->fetchAll();
            
                return $resultado;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>