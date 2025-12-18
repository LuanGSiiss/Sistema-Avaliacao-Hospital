<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/manutencao-padrao-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/login/login-styles.css">
</head>
<body>
    <div class="estrutura">
        <div>
            <form class="formulario" method="post" action="<?= BASE_URL ?>login">
                <div class="inputs">
                    <p>
                        <label for="email">E-mail</label>
                        <input type="email" name="email" required>
                    </p>
                    <p>
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" required>
                    </p>
                </div>
                <button id="enviar" type="submit">Entrar</button>
                <button id="limpar" type="reset">Limpar</button>
            </form>
            <!-- mensagens -->
            <?php if (isset($mensagens['erroLogin'])): ?>
                <p class="mensagem erro"><?= htmlspecialchars($mensagens['erroLogin']) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
