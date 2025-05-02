<?php
    require_once 'conexaoPg.php';

    function validarLogin($email, $senha) {
        try {
            $pdo = getConexao();
            if($pdo) {
            
                $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
                $stmt = $pdo->prepare($sql);
                $stmt->execute(['email' => $email, 'senha' => $senha]);
                $usuario = $stmt->fetch();

                return $usuario ? $usuario : false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }
?>

