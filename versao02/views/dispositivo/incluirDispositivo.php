<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incluir Dispositivo</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css"> <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/manutencao-padrao-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaDispositivos">Voltar</a>
            <form class="formulario" method="post" action="<?= BASE_URL ?>dispositivo/incluir">
                <div class="inputs">
                    <p>
                        <label for="setor">Setor</label>
                        <select name="setor" id="setor" required>
                            <option value>Selecione...</option>
                        <?php foreach ($setoresAtivos as $setor): ?>
                            <option value="<?= $setor['id_setor'] ?>" 
                            <?= (isset($dispositivoPreenchido['idSetor']) && $dispositivoPreenchido['idSetor'] == $setor['id_setor'] ) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($setor['descricao']) ?></option>
                        <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label for="codigo_identificador" >Código Identificador</label>
                        <input type="text" name="codigo_identificador" id="codigo_identificador" maxlength="7" placeholder="AAA-123" required value="<?= isset($dispositivoPreenchido['codigoIdentificador']) ? htmlspecialchars($dispositivoPreenchido['codigoIdentificador']) : '' ?>">
                    </p>
                    <p>
                        <label for="nome" >Nome</label>
                        <input type="text" name="nome" id="nome" maxlength="50" placeholder="Mesa 1" required value="<?= isset($dispositivoPreenchido['nome']) ? htmlspecialchars($dispositivoPreenchido['nome']) : '' ?>">
                    </p>
                </div>
                <button id="enviar" type="submit">Enviar</button>
                <button id="limpar" type="reset">Limpar</button>
            </form>
            <!-- mensagens -->
            <?php if (isset($mensagens['erroRegistro'])): ?>
                <p class="mensagem erro"><?= htmlspecialchars($mensagens['erroRegistro']) ?></p>
            <?php elseif (isset($mensagens['sucessoMensagem'])): ?>
                <p class="mensagem sucesso"><?= htmlspecialchars($mensagens['sucessoMensagem']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
