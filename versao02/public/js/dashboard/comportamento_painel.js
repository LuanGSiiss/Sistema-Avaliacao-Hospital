import { carregarGraficos } from './graficos.js';

enviarRequisicaoBuscarIndicadores();

document.getElementById("butaoConsulta").addEventListener("click", function () {
    enviarRequisicaoBuscarIndicadores();
});

function enviarRequisicaoBuscarIndicadores() {
    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./dashboard/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status === 'sucesso') {
    
                    const conteudo = dadosResposta.data;
    
                    if (conteudo) {
                        carregarGraficos(conteudo.indicadores);
                        exibirMediasNotasPorPergunta(conteudo.indicadores.mediasNotasPorPergunta);
                    } else {
                        exibirMensagemRetorno('Nenhum registro encontrado.', 0);
                        console.log("Nenhum registro encontrado");
                    }
                } else {
                    exibirMensagemRetorno('Erro com os dados da requisição.', 0);
                    console.log(dadosResposta.message);
                }
            } catch (erro) {
                exibirMensagemRetorno('Erro ao tratar os dados da requisição.', 0);
                console.error("Erro ao tratar os dados da requisição: ", erro.message);
            }
        } else if(func_assinc.status === 400 || func_assinc.status === 500) {
            var dadosResposta;
            try {
                dadosResposta = JSON.parse(func_assinc.responseText).message;
                
            } catch {
                dadosResposta = func_assinc.responseText;
            }
            exibirMensagemRetorno(dadosResposta, 0);
            console.error(dadosResposta);
        } else {
            alert("requisição invalida");
        }
    };
    
    func_assinc.send();
}

function exibirMediasNotasPorPergunta(dados) {
    const divIndicador = document.getElementById('mediasNotasPorPergunta');
    divIndicador.innerHTML = '';

    const tabelaIndicador = criarTabela(['Pergunta', 'Média']);
    const tbody = tabelaIndicador.querySelector('tbody');
    
    dados.forEach( pergunta => {
        let media = pergunta.media ? parseFloat(pergunta.media).toFixed(2) : '-';

        adicionarLinha(tbody, [
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

        //estilo adicional para a média
        if (index === valores.length - 1) {
            let corNota = parseFloat(valor) >= 8 ? '#065f46' : (parseFloat(valor) < 5 ? '#991b1b' : '#333');
            
            celula.style.color = corNota;
            celula.style.textAlign = 'center';
        }
    });
};

function exibirMensagemRetorno(mensagem, situacao) {
    const mensagemStatus = document.createElement('div');
    const conteudoMensagem = document.createElement('p');
    conteudoMensagem.className = "mensagem-texto";
    conteudoMensagem.textContent  = mensagem;

    const slideTempo = document.createElement('div');
    slideTempo.className = "slide-tempo";

    const barraSlideTempo = document.createElement('div');
    barraSlideTempo.className = "barra";

    document.body.appendChild(mensagemStatus);
    mensagemStatus.appendChild(conteudoMensagem);
    mensagemStatus.appendChild(slideTempo);
    slideTempo.appendChild(barraSlideTempo);
    
    // 1 = sucesso, 0 = erro
    if (situacao == 1) {
        mensagemStatus.className = "mensagem sucesso";
    } else {
        mensagemStatus.className = "mensagem erro";
    }
    
    setTimeout(() => {
        mensagemStatus.remove();
    }, 8000);
}

