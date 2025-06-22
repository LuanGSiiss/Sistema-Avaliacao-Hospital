// Chamada Principal
document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./consultaAvaliacoes/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                console.log(func_assinc.responseText)
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status = 'sucesso') {
                    const tbody = tabela.querySelector('tbody');
                    limparCorpoTabela(tabela);
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo || !conteudo.avaliacoes || conteudo.avaliacoes.length === 0) {
                        adicionarLinha(tbody, ["Nenhum registro encontrado"]);
                    } else {
                        conteudo.avaliacoes.forEach( avaliacao => {
                            adicionarLinha(tbody, [
                                avaliacao.id_avaliacao,
                                avaliacao.id_setor,
                                avaliacao.id_pergunta,
                                avaliacao.id_dispositivo,
                                avaliacao.nota,
                                avaliacao.feedback_textual,
                                avaliacao.datahora_cadastro
                            ]);
                        });
                    }
                } else {
                    alert("Erro com os dados da requisição.")
                    console.log(dadosResposta.message);
                }
            } catch (erro) {
                console.error("Erro ao parsear JSON:", erro.message);
            }
        } else {
            alert("requisição invalida");
        }
    };
    
    func_assinc.send();
});


function adicionarLinha(tabela, valores) {
    const novaLinha = tabela.insertRow();
    valores.forEach(valor => {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valor;
    });
};

function efeitoCarragamentoTabela(tabela) {
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = `
        <tr>
            <td colspan="7" style="text-align: center;">Carregando...</td>
        </tr>
    `;
}

function limparCorpoTabela(tabela) {
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = "";
}


