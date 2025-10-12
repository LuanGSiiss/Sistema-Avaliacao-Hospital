<?php
    require_once 'conexaoPg.php';

    function validarSetor($id_setor) {
        try {
            $pdo = getConexao();
            if($pdo) {
            
                $sql = "SELECT * FROM setor WHERE id_setor = :id_setor";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['id_setor' => $id_setor]);
                $setor = $stmt->fetch();

                return $setor ? true : false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
?>

