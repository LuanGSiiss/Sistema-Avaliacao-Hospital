document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    enviarRequisicaoBuscarRegistros('./consultaSetores/buscar', function (conteudo) {
        const tbody = tabela.querySelector('tbody');
        limparCorpoTabela(tabela);
        exibirConteudoSetores(conteudo, tbody);
    });
});

function exibirConteudoSetores(conteudo, corpoTabela) {
    if (!conteudo || !conteudo.setores || conteudo.setores.length === 0) {
        adicionarLinha(corpoTabela, ["Nenhum registro encontrado"]);
    } else {
        conteudo.setores.forEach( setor => {
            let situacao = setor.status ? "Ativo" : "Inativo";
            let acoes = montarAcoes(setor.id_setor, './setor/alterar/', './setor/visualizar/', './setor/excluir/');
    
            adicionarLinha(corpoTabela, [
                setor.id_setor,
                setor.descricao,
                situacao,
                acoes,
            ]);
        });
    }
}
