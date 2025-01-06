<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exemplo Sem AJAX</title>
</head>
<body>
    <h1>Carregar Dados Sem AJAX</h1>
    <form action="getData.php" method="GET">
        <button type="submit">Carregar Dados</button>
    </form>
    <div>
        <?php
        if (isset($_GET)) {
            echo file_get_contents("../data.txt");
        }
        ?>
    </div>
</body>
</html>
