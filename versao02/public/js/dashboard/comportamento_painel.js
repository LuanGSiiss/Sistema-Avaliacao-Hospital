enviarRequisicaoBuscarRegistros('./dashboard/buscar', function (conteudo) {
    exibirConteudoIndicadores(conteudo);
});

document.getElementById("butaoConsulta").addEventListener("click", function () {
    enviarRequisicaoBuscarRegistros('./dashboard/buscar', function (conteudo) {
        exibirConteudoIndicadores(conteudo);
    });
});

function exibirConteudoIndicadores(conteudo) {
    if (conteudo) {
        carregarGraficos(conteudo.indicadores);
        exibirMediasNotasPorPergunta(conteudo.indicadores.mediasNotasPorPergunta);
    } else {
        exibirMensagemRetorno('Nenhum registro encontrado.', 0);
    }
}

function exibirMediasNotasPorPergunta(dados) {
    const divIndicador = document.getElementById('mediasNotasPorPergunta');
    divIndicador.innerHTML = '';

    const tabelaIndicador = criarTabela(['Código', 'Pergunta', 'Média']);
    const tbody = tabelaIndicador.querySelector('tbody');
    
    dados.forEach( pergunta => {
        let media = pergunta.media ? parseFloat(pergunta.media).toFixed(2) : '-';

        adicionarLinha(tbody, [
            pergunta.id_pergunta,
            pergunta.texto_pergunta,
            media
        ]);
    });
    
    divIndicador.appendChild(tabelaIndicador);
}

function criarTabela(cabecalho) {
    const tabela = document.createElement('table');
    const thead = document.createElement('thead');
    const tbody = document.createElement('tbody');
    
    tabela.appendChild(thead);
    tabela.appendChild(tbody);
    
    const linhaCabecalho = thead.insertRow();
    cabecalho.forEach(valor => {
        linhaCabecalho.innerHTML += `<th>${valor}</th>`;
    })
    
    thead.appendChild(linhaCabecalho);
    
    return tabela;
};

// Sobreescrevendo função padrão
function adicionarLinha(tabela, valores) {
    const novaLinha = tabela.insertRow();
    //Para quando não for encontrado nenhum registo
    if (valores.length === 1) {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valores[0];
        celula.colSpan = 2;
        celula.style.cssText = 'text-align: center;';
        return;
    }
    
    valores.forEach((valor, index) => {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valor;

        // altera o estilo dependendo da nota
        if (index === valores.length - 1) {
            let corNota = parseFloat(valor) >= 8 ? '#065f46' : (parseFloat(valor) < 5 ? '#991b1b' : '#333');
            
            celula.style.color = corNota;
            celula.style.textAlign = 'center';
        }
    });
};
