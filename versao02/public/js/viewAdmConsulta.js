function adicionarLinha(tabela, valores) {
    const novaLinha = tabela.insertRow();
    valores.forEach(valor => {
        const celula = novaLinha.insertCell();
        celula.innerHTML = valor;
    });
};

function limparCorpoTabela(tabela) {
    const tbody = tabela.querySelector('tbody');
    tbody.innerHTML = "";
}

document.getElementById("butaoConsulta").addEventListener("click", function () {
    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "../src/controller_consulta.php", true);
    
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const stringJSON = func_assinc.responseText;
                const tabela = document.getElementById("resultadoConsulta");
                const tbody = tabela.querySelector('tbody');
                limparCorpoTabela(tabela);

                const conteudo = JSON.parse(stringJSON);

                if (!conteudo || !conteudo.perguntas || conteudo.perguntas.length === 0) {
                    adicionarLinha(tbody, ["Nenhum registro encontrado"]);
                } else {
                    conteudo.perguntas.forEach( pergunta => {
                        adicionarLinha(tbody, [
                            pergunta.id_avaliacao,
                            pergunta.id_setor,
                            pergunta.id_pergunta,
                            pergunta.id_dispositivo,
                            pergunta.resposta,
                            pergunta.feedback_textual,
                            pergunta.horario
                        ]);
                    });
                    
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
