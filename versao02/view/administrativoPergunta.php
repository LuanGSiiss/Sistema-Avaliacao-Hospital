<?php
    require "../controller/validaSessao.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativo</title>
    <link rel="stylesheet" href="css/paginaAdministrativaPer.css">
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
    <section class="estrutura">
        <div>
            <form class="formulario-Pergunta" id="formularioPergunta">
                <div class="inputs">
                    <label for="texto_pergunta" >Texto da Pergunta</label>
                    <textarea name="texto_pergunta" id="texto_pergunta" maxlength="350" rows="5" oninput="contagemCaracteres()" placeholder="Achei bom porque..."></textarea>
                    <p class="contadorChar" id="contadorChar">0/350 caracteres</p>
                </div>
                <button id="enviar" type="submit">Enviar</button>
            </form>
            <p class="mensagem" id="mensagem"></p>
        </div>
    </section>
</body>
<script src="js/viewAdmPergunta.js"></script>
</html>