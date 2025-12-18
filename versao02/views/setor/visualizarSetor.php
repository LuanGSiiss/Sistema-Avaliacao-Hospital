<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Setor</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css"> <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/manutencao-padrao-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaSetores">Voltar</a>
            <div class="formulario">
                <div class="inputs">
                    <p>
                        <label for="codigo" >Código</label>
                        <input type="number" name="codigo" id="codigo" disabled value="<?= htmlspecialchars($setor['id_setor']) ?>">
                    </p>
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