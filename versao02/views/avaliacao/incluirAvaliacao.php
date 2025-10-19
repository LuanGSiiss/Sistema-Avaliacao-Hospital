<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação do Hospital Regional do Alto Vale</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/avaliacao/manutencao-avaliacao-styles.css">
    <script src="<?= BASE_URL ?>public/js/avaliacao/comportamento_manutencaoAvaliacao.js" defer></script>
</head>
<body>
    <div class="estrutura">
        <form class="avaliacao" method="post" action="<?= BASE_URL ?>avaliacao/incluir?setor=<?= $setor ?>&dispositivo=<?= $dispositivo ?>">
            <h1>Avaliação do Hospital Regional do Alto Vale</h1>
            <?php if (isset($pergunta)): ?>
                <p class="pergunta"> <?= htmlspecialchars($pergunta['texto_pergunta']) ?> </p>
                <input type="hidden" value="<?= $pergunta['id_pergunta'] ?>" name="id_pergunta">
            <?php else: ?>
                <p> *Ainda não há nenhuma pergunta cadastrada no sistema.* </p>
            <?php endif; ?>
            <label style="margin-bottom: 0%;">
                Feedback(opcional)
                <textarea name="feedback" placeholder="Achei bom porque..."></textarea>
            </label>
            
            <div class="paremetro_nota">
                <p style="margin-bottom: 0%;">Improvável</p>
                <p style="margin-bottom: 0%;">Muito Provável</p>
            </div>
            <div class="avaliacao_nota">
                <button class="button_normal" type="button" data-value="1" id="nota1" onclick="selecionarNota(this)">1</button>
                <button class="button_normal" type="button" data-value="2" id="nota2" onclick="selecionarNota(this)">2</button>
                <button class="button_normal" type="button" data-value="3" id="nota3" onclick="selecionarNota(this)">3</button>
                <button class="button_normal" type="button" data-value="4" id="nota4" onclick="selecionarNota(this)">4</button>
                <button class="button_normal" type="button" data-value="5" id="nota5" onclick="selecionarNota(this)">5</button>
                <button class="button_normal" type="button" data-value="6" id="nota6" onclick="selecionarNota(this)">6</button>
                <button class="button_normal" type="button" data-value="7" id="nota7" onclick="selecionarNota(this)">7</button>
                <button class="button_normal" type="button" data-value="8" id="nota8" onclick="selecionarNota(this)">8</button>
                <button class="button_normal" type="button" data-value="9" id="nota9" onclick="selecionarNota(this)">9</button>
                <button class="button_normal" type="button" data-value="10" id="nota10" onclick="selecionarNota(this)">10</button>
            </div>
            <input type="hidden" name="nota" id="nota_selecionada">
            
            <button class="button_enviar" type="submit" disabled title="Selecione uma nota para habilitar">Enviar</button>
            
            <p class="aviso">Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </form>
        <!-- mensagem -->
        <?php if (isset($mensagens['erroRegistro'])): ?>
            <p class="mensagem erro"><?= htmlspecialchars($mensagens['erroRegistro']) ?></p>
        <?php elseif (isset($mensagens['sucessoMensagem'])): ?>
            <p class="mensagem sucesso"><?= htmlspecialchars($mensagens['sucessoMensagem']) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
<?php if (isset($mensagens['erroRegistro'])): ?>
    <script>
        console.error("Erro ao registrar a Avaliação: <?= addslashes($mensagens['erroRegistro']) ?>");
    </script>
<?php endif; ?>