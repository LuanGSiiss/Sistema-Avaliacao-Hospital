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

    <button id="butaoConsulta">Consultar</button>

    <!-- Média das notas por setor -->
    <div style="width: 800px;"><canvas id="mediasNotasUltimosMeses"></canvas></div>
    <div style="width: 800px;"><canvas id="mediasNotasPorSetor"></canvas></div>
    <div style="width: 500px;"><canvas id="proporcaoAvaliacoesPorSetor"></canvas></div>

</body>
</html>