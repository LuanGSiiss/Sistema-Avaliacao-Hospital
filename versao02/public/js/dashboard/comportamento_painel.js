import { carregarGraficos } from './graficos.js';

document.getElementById("butaoConsulta").addEventListener("click", function () {

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./dashboard/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status === 'sucesso') {
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo) {
                        console.log("Nenhum registro encontrado");
                    } else {
                        carregarGraficos(conteudo.indicadores);
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
});

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
