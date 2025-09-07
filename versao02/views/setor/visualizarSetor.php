<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Setor</title>
    <!-- links do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/setor/manutencao-setor-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaSetores">Voltar</a>
            <div class="formulario-setor">
                <div class="inputs">
                    <p>
                        <label for="descricao" >Descrição</label>
                        <input type="text" name="descricao" id="descricao" maxlength="50" placeholder="Recepção" required disabled value="<?= htmlspecialchars($setor['descricao']) ?>"/>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>