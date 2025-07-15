<?php
    require_once __DIR__ . '/../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/avaliacao/agradecimento-styles.css">
    <title>Agradecimento</title>
    <script>
        let countdown = 5;

        function updateCountdown() {
            const contador = document.getElementById('contador');
            contador.textContent = countdown;

            if (countdown === 0) {
                window.location.href = 'cadastroAvaliacao';
            } else {
                countdown--;
                setTimeout(updateCountdown, 1000);
            }
        }

        window.onload = updateCountdown;
    </script>
</head>
<body>
    <div class="estrutura">
        <div class="agradecimento">
            <div class="texto">
                <h1>Obrigado pela sua Avaliação!</h1>
                <p>Você será redirecionado para a página de avaliação em <span id="contador">5</span> segundos.</p>
            </div>
        </div>
    </div>
</body>
</html>
