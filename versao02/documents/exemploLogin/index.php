<?php
    require_once('conexao.php');

    if (isset($_POST['email']) || isset($_POST['senha'])) {

        if (strlen($_POST['email']) == 0) {
            echo "Preencha seu email";
        } else if (strlen($_POST['senha']) == 0) {
            echo "Preencha sua senha";
        } else {

            $email = $_POST['email'];
            $senha = $_POST['senha'];
            try {
                $dbconn = pg_connect(getStringConn());
                if($dbconn) {
                    
                    $query = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha';";
                    $result = pg_query($dbconn, $query);

                    if (pg_num_rows($result) == 1) {
                        $usuario = pg_fetch_assoc($result);
                        
                        if (!isset($_SESSION)) {
                            session_start();
                        }

                        $_SESSION['id_usuario'] = $usuario['id_usuario'];
                        $_SESSION['nome'] = $usuario['nome'];

                        header("Location: painel.php");

                    } else {
                        echo "Falha ao logar! E-mail ou senha incorretos";
                    }
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="POST">
        <p>
            <label for="email">E-mail</label>
            <input type="email" name="email">
        </p>
        <p>
            <label for="senha">Senha</label>
            <input type="password" name="senha">
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>
</body>
</html>