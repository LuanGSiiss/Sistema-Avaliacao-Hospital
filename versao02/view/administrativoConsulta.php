<?php
    // require "../controller/validaSessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo</title>
    <link rel="stylesheet" href="../public/css/paginaAdministrativaCon.css">
</head>
<body>
    <header class="menu">
        <nav>
            <ul class="menu-list">
                <li><a href="administrativoConsulta.php">Avaliações</a></li>
                <li><a href="administrativoPergunta.php">Cadastro de Pergunta</a></li>
            </ul>
        </nav>
    </header>
    <section class="estrura-conteudo">
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
                        <th class="td-codigo">Código</th>
                        <th class="td-setor">Setor</th>
                        <th class="td-pergunta">Código Pergunta</th>
                        <th class="td-dispositivo">Código Dispositivo</th>
                        <th class="td-nota">Nota</th>
                        <th class="td-feedback">Feedback Textual</th>
                        <th class="td-horario">Horário</th>
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
<script src="../public/viewAdmConsulta.js"></script>
</html>