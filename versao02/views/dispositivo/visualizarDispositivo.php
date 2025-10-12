

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Dispositivo</title>
    <!-- links do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/dispositivo/manutencao-dispositivo-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once __DIR__ .  '/../layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaDispositivos">Voltar</a>
            <div class="formulario-dispositivo">
                <div class="inputs">
                    <p>
                        <label for="codigo" >Código</label>
                        <input type="number" name="codigo" id="codigo" disabled value="<?= htmlspecialchars($dispositivo['id_dispositivo']) ?>">
                    </p>
                    <p>
                        <label for="setor">Setor</label>
                        <select name="setor" id="setor" disabled>
                            <option value>Selecione...</option>
                        <?php foreach ($setoresAtivos as $setor): ?>
                            <option value="<?= $setor['id_setor'] ?>" 
                            <?= $dispositivo['id_setor'] === $setor['id_setor'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($setor['descricao']) ?></option>
                        <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label for="codigo_identificador" >Código Identificador</label>
                        <input type="text" name="codigo_identificador" id="codigo_identificador" maxlength="7" placeholder="AAA-123" disabled value="<?= htmlspecialchars($dispositivo['codigo_identificador']) ?>">
                    </p>
                    <p>
                        <label for="nome" >Nome</label>
                        <input type="text" name="nome" id="nome" maxlength="50" placeholder="Mesa 1" disabled value="<?= htmlspecialchars($dispositivo['nome']) ?>">
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>