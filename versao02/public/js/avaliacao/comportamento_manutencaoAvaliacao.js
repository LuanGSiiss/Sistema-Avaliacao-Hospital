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
    const inputIdPergunta = document.querySelector('#id_pergunta');
    if(inputIdPergunta) {
        botaoEnviar.disabled = false;
    }
}