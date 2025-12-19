<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css"> <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/consulta-padrao-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/dashboard/painel.css">
    <!-- charjs -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="<?= BASE_URL ?>public/js/global/comportamento_consultaPadrao.js" defer></script>
    <script src="<?= BASE_URL ?>public/js/dashboard/graficos.js" defer></script>
    <script src="<?= BASE_URL ?>public/js/dashboard/comportamento_painel.js" defer></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <div class="dashboard-container">
        <div class="dashboard-header">
            <div>
                <h1>Visão Geral</h1>
                <p>Acompanhamento de métricas e indicadores</p>
            </div>
            <button id="butaoConsulta" class="botao-consulta">↻ Atualizar Dados</button>
        </div>

        <div class="dashboard-grid">
            <div class="card card-total">
                <div class="card-titulo">
                    <h3>Evolução das Notas (Últimos 12 Meses)</h3>
                </div>
                <div class="card-conteudo">
                    <div class="grafico">
                        <canvas id="mediasNotasUltimosMeses"></canvas>
                    </div>
                </div>
            </div>

            <div class="card card-maior">
                <div class="card-titulo">
                    <h3>Média por Setor</h3>
                </div>
                <div class="card-conteudo">
                    <div class="grafico">
                        <canvas id="mediasNotasPorSetor"></canvas>
                    </div>
                </div>
            </div>

            <div class="card card-menor">
                <div class="card-titulo">
                    <h3>Proporção de Avaliações</h3>
                </div>
                <div class="card-conteudo">
                    <div class="grafico grafico-pizza">
                        <canvas id="proporcaoAvaliacoesPorSetor"></canvas>
                    </div>
                </div>
            </div>

            <div class="card card-total" id="containerTabela">
                <div class="card-titulo">
                    <h3>Detalhamento por Pergunta</h3>
                </div>
                <div class="card-conteudo">
                    <div class="consulta" id="mediasNotasPorPergunta">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>