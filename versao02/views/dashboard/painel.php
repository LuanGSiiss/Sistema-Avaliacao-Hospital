<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- links do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/dashboard/painel.css">
    <script type="module" src="<?= BASE_URL ?>public/js/dashboard/graficos.js"></script>
    <script type="module" src="<?= BASE_URL ?>public/js/dashboard/comportamento_painel.js" defer></script>
    
    <!-- charjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once __DIR__ .  '/../layout/menu.php'; ?>

    <button id="butaoConsulta" class="butao-consulta">Consultar</button>

    <!-- Média das notas por setor -->
    <div class="estrutura">
        <div class="mediasNotasUltimosMeses"><canvas id="mediasNotasUltimosMeses"></canvas></div>
        <div class="proporcaoAvaliacoesPorSetor"><canvas id="proporcaoAvaliacoesPorSetor"></canvas></div>
        <div class="mediasNotasPorSetor"><canvas id="mediasNotasPorSetor"></canvas></div>
        <div class="mediasNotasPorPergunta" id="mediasNotasPorPergunta">
            <h2>Média das Avaliações por Pergunta</h2>
        </div>
    </div>

</body>
</html>