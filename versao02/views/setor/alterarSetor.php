<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Pergunta</title>
    <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/setor/manutencao-setor-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class="estrutura">
        <div>
            <a href="<?= BASE_URL ?>consultaSetores">Voltar</a>
            <form class="formulario-setor" method="post" action="<?= BASE_URL ?>setor/alterar/<?= $setor['id_setor'] ?>">
                <div class="inputs">
                    <p>
                        <label for="codigo" >Código</label>
                        <input type="number" name="codigo" id="codigo" disabled value="<?= htmlspecialchars($setor['id_setor']) ?>">
                    </p>
                    <p>
                        <label for="descricao" >Descrição</label>
                        <input type="text" name="descricao" id="descricao" maxlength="50" placeholder="Recepção" required value="<?= isset($setorPreenchido['descricao']) ? htmlspecialchars($setorPreenchido['descricao']) : htmlspecialchars($setor['descricao']) ?>"/>
                    </p>
                </div>
                <button id="enviar" type="submit">Enviar</button>
                <button id="limpar" type="reset">Limpar</button>
            </form>
            <!-- mensagem -->
            <?php if (isset($mensagens['erroRegistro'])): ?>
                <p class="mensagem erro"><?= htmlspecialchars($mensagens['erroRegistro']) ?></p>
            <?php elseif (isset($mensagens['sucessoMensagem'])): ?>
                <p class="mensagem sucesso"><?= htmlspecialchars($mensagens['sucessoMensagem']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
<!-- Exibir erro no console -->
<?php if (isset($mensagens['erroRegistro'])): ?>
    <script>
        console.error("Erro ao registrar o Setor: <?= addslashes($mensagens['erroRegistro']) ?>");
    </script>
<?php endif; ?>