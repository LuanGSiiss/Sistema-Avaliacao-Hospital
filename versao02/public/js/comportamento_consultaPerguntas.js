// Chamada Principal
document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./consultaPerguntas/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                console.log(func_assinc.responseText)
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status = 'sucesso') {
                    const tbody = tabela.querySelector('tbody');
                    limparCorpoTabela(tabela);
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo || !conteudo.perguntas || conteudo.perguntas.length === 0) {
                        adicionarLinha(tbody, ["Nenhum registro encontrado"]);
                    } else {
                        conteudo.perguntas.forEach( pergunta => {
                            let todos_setores = pergunta.todos_setores ? "Sim" : "Não";
                            let situacao = pergunta.status ? "Ativo" : "Inativo";

                            adicionarLinha(tbody, [
                                pergunta.id_pergunta,
                                pergunta.texto_pergunta,
                                todos_setores,
                                situacao,
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
            <td colspan="4" style="text-align: center;">Carregando...</td>
        </tr>
    `;
}

function limparCorpoTabela(tabela) {
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = "";
}


