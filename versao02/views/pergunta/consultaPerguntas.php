<?php
    // require "../controller/validaSessao.php";
    require_once __DIR__ . '/../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Perguntas</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/pergunta/consulta-perguntas-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once __DIR__ .  '/../layout/menu.php'; ?>

    <section class="estrutura">
        <div class="cabecalho-consulta">
            <h1>Consulta de Perguntas</h1>
            <button id="butaoConsulta">Consultar</button>
        </div>
        <a href="<?= BASE_URL ?>pergunta/incluir">Incluir</a>
        <div class="consulta" >
            <table id="resultadoConsulta">
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 68%;">
                    <col style="width: 10%;">
                    <col style="width: 5%;">
                    <col style="width: 12%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Todos os Setores</th>
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
<script src="<?= BASE_URL ?>public/js/comportamento_consultaPerguntas.js"></script>
</html>