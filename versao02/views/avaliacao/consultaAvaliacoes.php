<?php
    // require "../controller/validaSessao.php";
    require_once __DIR__ . '/../../utils/config.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Avaliações</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/avaliacao/consulta-avaliacoes-styles.css">
</head>
<body>
    <!-- Menu -->
    <?php require_once __DIR__ .  '/../layout/menu.php'; ?>

    <section class="estrutura">
        <div class="cabecalho-consulta">
            <h1>Consulta de Avaliações</h1>
            <button id="butaoConsulta">Consultar</button>
        </div>
        <div class="consulta" >
            <table id="resultadoConsulta">
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 5%;">
                    <col style="width: 5%;">
                    <col style="width: 5%;">
                    <col style="width: 5%;">
                    <col style="width: 65%;">
                    <col style="width: 10%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Setor</th>
                        <th>Código Pergunta</th>
                        <th>Código Dispositivo</th>
                        <th>Nota</th>
                        <th>Feedback Textual</th>
                        <th>Data/Hora do Cadastro</th>
                    </tr>
                </thead>
                <tbody>
                    <td colspan="7" class="efeitoCarragamento">Clique em "Consultar" para exibir os dados.</td>
                    <!--Conteudo da busca-->
                </tbody>
            </table>
        </div>
    </section>
    
</body>
<script src="<?= BASE_URL ?>public/js/comportamento_consultaAvaliacoes.js"></script>
</html>