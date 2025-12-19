document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    enviarRequisicaoBuscarRegistros('./consultaDispositivos/buscar', function (conteudo) {
        const tbody = tabela.querySelector('tbody');
        limparCorpoTabela(tabela);
        exibirConteudoDispositivos(conteudo, tbody);
    });
});

function exibirConteudoDispositivos(conteudo, corpoTabela) {
    if (!conteudo || !conteudo.dispositivos || conteudo.dispositivos.length === 0) {
        adicionarLinha(corpoTabela, ["Nenhum registro encontrado"]);
    } else {
        setores = conteudo.setores;
        
        conteudo.dispositivos.forEach( dispositivo => {
            let setor = setores.find(setor => setor['id_setor'] === dispositivo.id_setor).descricao;
            let situacao = dispositivo.status ? "Ativo" : "Inativo";
            let acoes = montarAcoes(dispositivo.id_dispositivo, './dispositivo/alterar/', './dispositivo/visualizar/', './dispositivo/excluir/');
            
            adicionarLinha(corpoTabela, [
                dispositivo.id_dispositivo,
                dispositivo.codigo_identificador,
                dispositivo.nome,
                setor,
                situacao,
                acoes,
            ]);
        });
    }
}
