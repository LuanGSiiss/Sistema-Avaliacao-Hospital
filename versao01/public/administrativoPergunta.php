<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo</title>
    <link rel="stylesheet" href="css/paginaAdministrativaPer.css">
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
    <div class="conteudo">
        <form action="" method="post">
            <p style="margin-bottom: 0%;">Informe o texto da pergunta</p>
            <textarea name="texto_pergunta" placeholder="Achei bom porque..."></textarea><br>
            <button type="submit">Enviar</button>
        </form>
    </div>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            require_once('../src/config.php');

            try {
                $dbconn = pg_connect(getStringConn());
                if($dbconn) {

                    $texto_pergunta = $_POST['texto_pergunta'];

                    $query = "INSERT INTO perguntas(texto_pergunta) VALUES('$texto_pergunta');";
    
                    $result = pg_query($dbconn, $query);
                }
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            
            pg_close($dbconn);
        }
    ?>
</body>
</html>