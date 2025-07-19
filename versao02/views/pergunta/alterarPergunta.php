<?php
    // require "../controller/validaSessao.php";
    require_once __DIR__ . '/../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pergunta</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/pergunta/manutencao-pergunta-styles.css">

    <!-- CSS do Select2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-rc.0/css/select2.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once __DIR__ .  '/../layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaPerguntas">Voltar</a>
            <form class="formulario-pergunta" method="post" action="<?= BASE_URL ?>pergunta/alterar/<?= $pergunta['id_pergunta'] ?>">
                <div class="inputs">
                    <div>
                        <label for="todos_setores">Todos os Setores?</label>
                        <input type="checkbox" value="1" name="todos_setores" id="todos_setores" <?= ($pergunta['todos_setores']) ? 'checked' : '' ?>>
                    </div>
                    <p>
                        <label for="setores">Setores</label>
                        <select name="setores[]" name="setores" id="setores" multiple required>
                            <?php foreach ($setoresAtivos as $setor): ?>
                                <option value="<?= $setor['id_setor'] ?>" <?= in_array($setor['id_setor'], $perguntaSetores) ? 'selected' : '' ?>><?= htmlspecialchars($setor['descricao']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </p>
                    <p>
                        <label for="texto_pergunta" >Texto da Pergunta</label>
                        <textarea name="texto_pergunta" id="texto_pergunta" maxlength="350" rows="5" oninput="contagemCaracteres()" placeholder="Achei bom porque..." required><?= $pergunta['texto_pergunta'] ?></textarea>
                        <p class="contador-char" id="contadorChar">0/350 caracteres</p>
                    </p>
                </div>
                <button id="enviar" type="submit">Enviar</button>
                <button id="limpar" type="reset">Limpar</button>
            </form>
            <!-- mensagem -->
            <?php if (isset($mensagens['erroRegistroPergunta'])): ?>
                <p class="mensagem erro"><?= htmlspecialchars($mensagens['erroRegistroPergunta']) ?></p>
            <?php elseif (isset($mensagens['sucessoMensagem'])): ?>
                <p class="mensagem sucesso"><?= htmlspecialchars($mensagens['sucessoMensagem']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
<script src="<?= BASE_URL ?>public/js/comportamento_incluirPergunta.js"></script>
<script>
    $(document).ready(function() {
        $('#setores').select2({
            placeholder: "Selecione os setores",
            allowClear: true,
            width: '80%'
        });
    });
</script>
</html>
<?php if (isset($mensagens['erroRegistroPergunta'])): ?>
    <script>
        console.error("Erro ao registrar a Pergunta: <?= addslashes($mensagens['erroRegistroPergunta']) ?>");
    </script>
<?php endif; ?>