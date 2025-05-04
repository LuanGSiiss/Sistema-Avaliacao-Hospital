<?php 
    require_once 'conexaoPg.php';

    function consultaSetores() {
        try {
            $pdo = getConexao();
            if($pdo) {
            
                $sql = "SELECT * FROM setor ORDER BY id_setor;";
                $stmt = $pdo->query($sql);
                $resultado = $stmt->fetchAll();
            
                return $resultado;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
?>