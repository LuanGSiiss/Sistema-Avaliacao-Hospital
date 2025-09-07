<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Setores</title>
    <!-- link do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/layout/menu-styles.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/setor/consulta-setores-styles.css">
    <script src="<?= BASE_URL ?>public/js/setor/comportamento_consultaSetores.js" defer></script>
</head>
<body>
    <!-- Menu -->
    <?php require_once BASE_PATH . '/views/layout/menu.php'; ?>

    <section class="estrutura">
        <div class="cabecalho-consulta">
            <h1>Consulta de Setores</h1>
            <button id="butaoConsulta">Consultar</button>
        </div>
        <a href="<?= BASE_URL ?>setor/incluir">Incluir</a>
        <div class="consulta" >
            <table id="resultadoConsulta">
                <colgroup>
                    <col style="width: 10%;">
                    <col style="width: 65%;">
                    <col style="width: 10%;">
                    <col style="width: 15%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Situação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="4" class="efeitoCarragamento">Clique em "Consultar" para exibir os dados.</td>
                    <!--Conteudo da busca-->
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>