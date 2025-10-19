const numeroColunas = 7

// Chamada Principal
document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./consultaAvaliacoes/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status = 'sucesso') {
                    const tbody = tabela.querySelector('tbody');
                    limparCorpoTabela(tabela);
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo || !conteudo.avaliacoes || conteudo.avaliacoes.length === 0) {
                        adicionarLinha(tbody, ["Nenhum registro encontrado"]);
                    } else {
                        setores = conteudo.setores;
                        dispositivos = conteudo.dispositivos;
                        
                        conteudo.avaliacoes.forEach( avaliacao => {
                            let setor = setores.find(setor => setor['id_setor'] === avaliacao.id_setor).descricao;
                            let codigoIdentificadorDispositivo = dispositivos.find(dispositivo => dispositivo['id_dispositivo'] === avaliacao.id_dispositivo).codigo_identificador;

                            adicionarLinha(tbody, [
                                avaliacao.id_avaliacao,
                                setor,
                                avaliacao.id_pergunta,
                                codigoIdentificadorDispositivo,
                                avaliacao.nota,
                                avaliacao.feedback_textual,
                                avaliacao.datahora_cadastro
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

    valores.forEach(valor => {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valor;
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
