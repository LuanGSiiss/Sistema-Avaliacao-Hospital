<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Dispositivos</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css"> <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/global-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/global/consulta-padrao-styles.css">
    <script src="<?= BASE_URL ?>public/js/dispositivo/comportamento_consultaDispositivos.js" defer></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <section class="estrutura">
        <div class="cabecalho-consulta">
            <h1>Consulta de Dispositivos</h1>
            <button id="butaoConsulta">Consultar</button>
        </div>
        <a href="<?= BASE_URL ?>dispositivo/incluir">Incluir</a>
        <div class="consulta" >
            <table id="resultadoConsulta">
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 10%;">
                    <col style="width: 45%;">
                    <col style="width: 15%;">
                    <col style="width: 10%;">
                    <col style="width: 15%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Código Identificador</th>
                        <th>Nome</th>
                        <th>Setor</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="6" class="efeitoCarragamento">Clique em "Consultar" para exibir os dados.</td>
                    <!--Conteudo da busca-->
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>