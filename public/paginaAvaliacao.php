<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/paginaAvaliacaostyles.css">
    <title>Avaliação do Hospital Regional do Alto vale</title>
</head>
<body>
    <div class="estrutura">
        <form class="avaliacao" action="../src/controller_registro_avaliacao.php" method="post">
            <h1>Avaliação do Hospital Regional do Alto Vale</h1>
            <?php
                require_once('../src/escreverPergunta.php');
                escreverPergunta();
            ?>
            <p style="margin-bottom: 0%;">Feedback(opcional)</p>
            <textarea name="feedback" placeholder="Achei bom porque..."></textarea>
            <div class="paremetro_nota">
                <p style="margin-bottom: 0%;">Improvável</p>
                <p style="margin-bottom: 0%;">Muito Provável</p>
            </div>
            <div class="avaliacao_nota">
                <button class="button_normal" type="button" data-value="1" id="nota1" onclick="selecionarNota(this)">1</button>
                <button class="button_normal" type="button" data-value="2" id="nota2" onclick="selecionarNota(this)">2</button>
                <button class="button_normal" type="button" data-value="3" id="nota3" onclick="selecionarNota(this)">3</button>
                <button class="button_normal" type="button" data-value="4" id="nota4" onclick="selecionarNota(this)">4</button>
                <button class="button_normal" type="button" data-value="5" id="nota5" onclick="selecionarNota(this)">5</button>
                <button class="button_normal" type="button" data-value="6" id="nota6" onclick="selecionarNota(this)">6</button>
                <button class="button_normal" type="button" data-value="7" id="nota7" onclick="selecionarNota(this)">7</button>
                <button class="button_normal" type="button" data-value="8" id="nota8" onclick="selecionarNota(this)">8</button>
                <button class="button_normal" type="button" data-value="9" id="nota9" onclick="selecionarNota(this)">9</button>
                <button class="button_normal" type="button" data-value="10" id="nota10" onclick="selecionarNota(this)">10</button>
            </div>
            <input type="hidden" name="nota" id="nota_selecionada">
            
            <button class="button_enviar" type="submit" disabled>Enviar</button>
            
            <p class="aviso">Sua avaliação espontânea é  anônima, nenhuma informação pessoal é solicitada ou armazenada.</p>
        </form>
    </div>
    
    <script>
        function selecionarNota(botaoClicado) {
            // Remove a classe 'button_selected' de todos os botões
            const botoes = document.querySelectorAll('.avaliacao_nota button');
            botoes.forEach(botao => botao.classList.remove('button_selected'));
            
            // Adiciona a classe 'button_selected' ao botão clicado
            botaoClicado.classList.add('button_selected');
            
            // Atualiza o valor no input oculto
            const notaSelecionadaInput = document.getElementById('nota_selecionada');
            notaSelecionadaInput.value = botaoClicado.getAttribute('data-value');

            // Habilita o botão de enviar
            const botaoEnviar = document.querySelector('.button_enviar');
            botaoEnviar.disabled = false;
        }
    </script>
</body>
</html>