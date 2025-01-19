

document.getElementById("consulta").addEventListener("click", function () {
    
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
    
    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "../src/controller_consulta.php", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                stringJSON = func_assinc.responseText;
                let tabela = document.getElementById("resultConsult");
                const tbody = tabela.querySelector('tbody');
                limparCorpoTabela(tabela);

                if (stringJSON == "{}") {
                    adicionarLinha(tbody, ["Nenhum registro encontrado"])
                } else {
                    conteudo = JSON.parse(stringJSON);

                    // Escreve as linhas
                    conteudo.perguntas.forEach( pergunta => {
                        adicionarLinha(tbody, [
                            pergunta.id_avaliacao,
                            pergunta.id_setor,
                            pergunta.id_pergunta,
                            pergunta.id_dispositivo,
                            pergunta.resposta,
                            pergunta.feedback_textual,
                            pergunta.horario
                        ])
                    })
                    
                }
                
            } catch (erro) {
                console.erros("Erro ao pasear JSON", erro.message);
            }

        } else {
            alert("requisição invalida");
        }
    };
    func_assinc.send();
});
