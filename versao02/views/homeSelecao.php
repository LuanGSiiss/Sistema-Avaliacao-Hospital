<?php
    require "../controller/validaSessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Seleção</title>
</head>
<body>
    <h1>Home Seleção</h1>

    <h2>Pagina Administrativa</h2>
    <span><a href="#">Administrativo</a></span>

    <h2>Pagina Avaliativa</h2>
    <span><a href="paginaAvaliacao.php" id="link-avaliacao">Avaliação</a></span>
    <p>
        <label for="setor">Setor</label>
        <select id="setores" name="setor">
            <option value="">
                Selecione...
            </option>
            <!-- Demais opções -->
        </select>
    </p>

</body>
<script src="js/comportamento_homeSelecao.js"></script>
</html>