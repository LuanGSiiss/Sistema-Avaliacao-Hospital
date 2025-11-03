const numeroColunas = 5

// Chamada Principal
document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./consultaPerguntas/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status === 'sucesso') {
                    const tbody = tabela.querySelector('tbody');
                    limparCorpoTabela(tabela);
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo || !conteudo.perguntas || conteudo.perguntas.length === 0) {
                        adicionarLinha(tbody, ["Nenhum registro encontrado"]);
                    } else {
                        conteudo.perguntas.forEach( pergunta => {
                            let todos_setores = pergunta.todos_setores ? "Sim" : "Não";
                            let situacao = pergunta.status ? "Ativo" : "Inativo";
                            let acoes = `
                            <a href="./pergunta/alterar/${pergunta.id_pergunta}" class="botaoAcao alterar">Alterar</a>
                            <a href="./pergunta/visualizar/${pergunta.id_pergunta}" class="botaoAcao visualizar">Visualizar</a>
                            <span onclick="mensagemExcluir(${pergunta.id_pergunta})" class="botaoAcao excluir">Excluir</span>
                            `

                            adicionarLinha(tbody, [
                                pergunta.id_pergunta,
                                pergunta.texto_pergunta,
                                todos_setores,
                                situacao,
                                acoes,
                            ]);
                        });
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


function adicionarLinha(tabela, valores) {
    const novaLinha = tabela.insertRow();
    //Para quando não for encontrado nenhum registo
    if (valores.length === 1) {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valores[0];
        celula.colSpan = numeroColunas;
        celula.style.cssText = 'text-align: center;';
        return;
    }
    
    valores.forEach((valor, index ) => {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valor;

        if (index === valores.length - 1) {
            celula.classList.add("colunaAcoes");
        }
        
    });
};

function efeitoCarragamentoTabela(tabela) {
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="${numeroColunas}" style="text-align: center;">Carregando...</td>
        </tr>
    `;
}

function limparCorpoTabela(tabela) {
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = "";
}

//Exclusão
function mensagemExcluir(idPergunta) {
    const divMensagem = document.createElement('div');
    divMensagem.className = 'divExcluir';
    divMensagem.id = 'divExcluir';

    const popMensagem = document.createElement('div');
    popMensagem.className = 'popExcluir';
    popMensagem.innerHTML = `
        <h2>Confirmação</h3>
        <p>Tem certeza que deseja excluir o registro?</p>
        <div class="botoesConfirmacao">
            <button class="buttonSim">Sim</button>
            <button id="buttonNao">Não</button>
        </div>
    `;

    divMensagem.appendChild(popMensagem);
    document.body.appendChild(divMensagem);
    
    popMensagem.querySelector(".buttonSim").addEventListener("click", () => excluirPergunta(idPergunta));
    popMensagem.querySelector("#buttonNao").addEventListener("click", () => fecharMensagemExcluir());
}

function excluirPergunta(idPergunta) {
    const divMensagem = document.getElementById("divExcluir");
    efeitoCarragamentoExcluir(divMensagem);

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("DELETE", `./pergunta/excluir/${idPergunta}`, true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            fecharMensagemExcluir();
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status === 'sucesso') {
                    document.getElementById("butaoConsulta").click();
                    exibirMensagemRetorno(dadosResposta.data.message, 1);
                } else {
                    exibirMensagemRetorno('Erro com os dados da requisição.', 0);
                    console.log(dadosResposta.message);
                }
            } catch (erro) {
                exibirMensagemRetorno('Erro ao tratar os dados da requisição', 0);
                console.error("Erro ao tratar os dados da requisição: ", erro.message);
            }
        } else if(func_assinc.status === 400 || func_assinc.status === 500) {
            fecharMensagemExcluir();
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

function efeitoCarragamentoExcluir(divMensagem) {
    divMensagem.innerHTML = `
        <div class="popExcluir">Aguarde...</div>
    `;
}

function fecharMensagemExcluir() {
    const divMensagem = document.getElementById("divExcluir");
    divMensagem.remove();
}

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