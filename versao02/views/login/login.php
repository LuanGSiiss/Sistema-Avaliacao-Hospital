<?php
    // require "../controller/validaSessao.php";
    require_once __DIR__ . '/../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="post" action="<?= BASE_URL ?>login">
        <p>
            <label for="email">E-mail</label>
            <input type="email" name="email" required>
        </p>
        <p>
            <label for="senha">Senha</label>
            <input type="password" name="senha" required>
        </p>
        <p>
            <button type="submit">Entrar</button>
        </p>
    </form>
</body>
</html>
<!-- Exibir erro no console -->
<?php if (isset($mensagens['erroRegistroPergunta'])): ?>
    <script>
        console.error("Erro ao registrar a Pergunta: <?= addslashes($mensagens['erroRegistroPergunta']) ?>");
    </script>
<?php endif; ?>