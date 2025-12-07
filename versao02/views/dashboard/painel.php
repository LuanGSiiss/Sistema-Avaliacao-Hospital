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

    <main class="dashboard-container">
        <div class="dashboard-header">
            <div>
                <h1>Visão Geral</h1>
                <p>Acompanhamento de métricas e indicadores</p>
            </div>
            <button id="butaoConsulta" class="botao-consulta">
                ↻ Atualizar Dados
            </button>
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
                    <div id="mediasNotasPorPergunta">
                        </div>
                </div>
            </div>
        </div>
    </main>

</body>
</html>