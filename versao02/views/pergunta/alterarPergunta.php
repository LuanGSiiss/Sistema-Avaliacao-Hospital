<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pergunta</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css"> <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/manutencao-padrao-styles.css">
    <script src="<?= BASE_URL ?>public/js/pergunta/comportamento_manutencaoPergunta.js" defer></script>
    <script src="<?= BASE_URL ?>public/js/pergunta/select2-setores.js" defer></script>
    <!-- CSS e JS do Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaPerguntas">Voltar</a>
            <form class="formulario" method="post" action="<?= BASE_URL ?>pergunta/alterar/<?= $pergunta['id_pergunta'] ?>">
                <div class="inputs">
                    <p>
                        <label for="codigo" >Código</label>
                        <input type="number" name="codigo" id="codigo" disabled value="<?= htmlspecialchars($pergunta['id_pergunta']) ?>">
                    </p>
                    <div class="checkbox-container">
                        <label for="todos_setores">Todos os Setores?</label>
                        <input type="checkbox" value="1" name="todos_setores" id="todos_setores" <?= isset($perguntaPreenchida['todosSetores']) 
                        ? ($perguntaPreenchida['todosSetores'] ? 'checked' : '') 
                        : ($pergunta['todos_setores'] ? 'checked' : '') ?>>
                    </div>
                    <p>
                        <label for="setores">Setores</label>
                        <select name="setores[]" id="setores" multiple required>
                        <?php foreach ($setoresAtivos as $setor): ?>
                            <option value="<?= $setor['id_setor'] ?>" 
                            <?= isset($perguntaPreenchida['setores'])
                            ? (in_array($setor['id_setor'], $perguntaPreenchida['setores']) ? 'selected' : '')
                            : (in_array($setor['id_setor'], $perguntaSetores) ? 'selected' : '') ?>>
                            <?= htmlspecialchars($setor['descricao']) ?></option>
                        <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label for="texto_pergunta" >Texto da Pergunta</label>
                        <textarea name="texto_pergunta" id="texto_pergunta" maxlength="350" rows="5" oninput="contagemCaracteres()" placeholder="Achei bom porque..." required><?= isset($perguntaPreenchida['textoPergunta']) ? htmlspecialchars($perguntaPreenchida['textoPergunta']) : htmlspecialchars($pergunta['texto_pergunta']) ?></textarea>
                        <p class="contador-char" id="contadorChar">0/350 caracteres</p>
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
</html>
