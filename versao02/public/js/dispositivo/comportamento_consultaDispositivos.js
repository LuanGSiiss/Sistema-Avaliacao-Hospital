// Cria requisição ajax de busca dos dispositivos
document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    const func_assinc = new XMLHttpRequest();
    func_assinc.open("GET", "./consultaDispositivos/buscar", true);
    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            try {
                const dadosResposta = JSON.parse(func_assinc.responseText);
                
                if (dadosResposta.status === 'sucesso') {
                    const tbody = tabela.querySelector('tbody');
                    limparCorpoTabela(tabela);
    
                    const conteudo = dadosResposta.data;
    
                    if (!conteudo || !conteudo.dispositivos || conteudo.dispositivos.length === 0) {
                        adicionarLinha(tbody, ["Nenhum registro encontrado"]);
                    } else {
                        setores = conteudo.setores;
                        
                        conteudo.dispositivos.forEach( dispositivo => {
                            let setor = setores.find(setor => setor['id_setor'] === dispositivo.id_setor).descricao;
                            let situacao = dispositivo.status ? "Ativo" : "Inativo";
                            let acoes = montarAcoes(dispositivo.id_dispositivo, './dispositivo/alterar/', './dispositivo/visualizar/', './dispositivo/excluir/');
                            
                            adicionarLinha(tbody, [
                                dispositivo.id_dispositivo,
                                dispositivo.codigo_identificador,
                                dispositivo.nome,
                                setor,
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
