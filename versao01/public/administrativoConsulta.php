<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo</title>
    <link rel="stylesheet" href="css/paginaAdministrativaCon.css">
</head>
<body>
    <header class="menu">
        <nav>
            <ul class="menu-list">
                <li><a href="administrativoConsulta.php">Avaliações</a></li>
                <li><a href="administrativoPergunta.php">Cadastro de Pergunta</a></li>
            </ul>
        </nav>
    </header>
    <div class="consulta">
        <form action="" method="POST">
            <button type="submit">Consultar</button>
        </form>
    </div>
    <table border="1" style='width:100%; border-collapse:collapse; text-align:left;'>
        <tr>
            <th>ID_avaliacao</th>
            <th>Setor</th>
            <th>ID_Pergunta</th>
            <th>ID_dispositivo</th>
            <th>Nota</th>
            <th>Feedback</th>
            <th>Horario</th>
        </tr>
        <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                require_once('../src/config.php');

                try {
                    $dbconn = pg_connect(getStringConn());
                    if($dbconn) {
                    
                        $query = "SELECT * FROM avaliacoes ORDER BY id_avaliacao;";
                        $result = pg_query($dbconn, $query);
                    
                        if (pg_num_rows($result) > 0) {
                            while ($row = pg_fetch_assoc($result)) {
                                echo "<tr><td>{$row['id_avaliacao']}</td><td>{$row['id_setor']}</td><td>{$row['id_pergunta']}</td><td>{$row['id_dispositivo']}</td><td>{$row['resposta']}</td><td>{$row['feedback_textual']}</td><td>{$row['horario']}</td></tr>";
                            }
                        } else {
                            echo "Nenhum dado encontrado.";
                        }
                    }
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            
                pg_close($dbconn);
            }
        ?>
    </table>
</body>
</html>