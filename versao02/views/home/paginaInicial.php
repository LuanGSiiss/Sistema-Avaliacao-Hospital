<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina Inicial</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css"> <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/home/home-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class='estrutura'>
        <div class="home-container">
            <h1>Sistema de Avaliação Hospitalar</h1>
            <p class="descricao">Bem-vindo ao sistema de avaliação do Hospital Regional do Alto Vale.</p>
        </div>
    </div>
</body>
</html>