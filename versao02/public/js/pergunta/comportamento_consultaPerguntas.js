document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    enviarRequisicaoBuscarRegistros('./consultaPerguntas/buscar', function (conteudo) {
        const tbody = tabela.querySelector('tbody');
        limparCorpoTabela(tabela);
        exibirConteudoPerguntas(conteudo, tbody);
    });
});

function exibirConteudoPerguntas(conteudo, corpoTabela) {
    
    if (!conteudo || !conteudo.perguntas || conteudo.perguntas.length === 0) {
        adicionarLinha(corpoTabela, ["Nenhum registro encontrado"]);
    } else {
        conteudo.perguntas.forEach( pergunta => {
            let todos_setores = pergunta.todos_setores ? "Sim" : "Não";
            let situacao = pergunta.status ? "Ativo" : "Inativo";
            let acoes = montarAcoes(pergunta.id_pergunta, './pergunta/alterar/', './pergunta/visualizar/', './pergunta/excluir/');
    
            adicionarLinha(corpoTabela, [
                pergunta.id_pergunta,
                pergunta.texto_pergunta,
                todos_setores,
                situacao,
                acoes,
            ]);
        });
    }
}
