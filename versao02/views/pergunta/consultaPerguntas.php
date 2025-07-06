<?php
    // require "../controller/validaSessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta Perguntas</title>
    <link rel="stylesheet" href="public/css/pergunta/consulta-perguntas-styles.css">
</head>
<body>
    <header class="menu">
        <nav>
            <ul class="menu-lista">
                <li><a href="./consultaAvaliacoes">Avaliações</a></li>
                <li><a href="./consultaPerguntas">Perguntas</a></li>
            </ul>
        </nav>
    </header>
    <section class="estrutura">
        <div class="cabecalho-consulta">
            <h1>Consulta de Perguntas</h1>
            <button id="butaoConsulta">Consultar</button>
        </div>
        <a href="./pergunta/incluir">Incluir</a>
        <div class="consulta" >
            <table id="resultadoConsulta">
                <colgroup>
                    <col style="width: 5%;">
                    <col style="width: 80%;">
                    <col style="width: 10%;">
                    <col style="width: 5%;">
                </colgroup>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Descrição</th>
                        <th>Todos os Setores</th>
                        <th>Situação</th>
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
<script src="public/js/comportamento_consultaPerguntas.js"></script>
</html>