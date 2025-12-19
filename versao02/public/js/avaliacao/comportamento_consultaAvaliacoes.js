document.getElementById("butaoConsulta").addEventListener("click", function () {
    const tabela = document.getElementById("resultadoConsulta");
    efeitoCarragamentoTabela(tabela);

    enviarRequisicaoBuscarRegistros('./consultaAvaliacoes/buscar', function (conteudo) {
        const tbody = tabela.querySelector('tbody');
        limparCorpoTabela(tabela);
        exibirConteudoAvaliacoes(conteudo, tbody);
    });
});

function exibirConteudoAvaliacoes(conteudo, corpoTabela) {
    if (!conteudo || !conteudo.avaliacoes || conteudo.avaliacoes.length === 0) {
        adicionarLinha(corpoTabela, ["Nenhum registro encontrado"]);
    } else {
        setores = conteudo.setores;
        dispositivos = conteudo.dispositivos;
        
        conteudo.avaliacoes.forEach( avaliacao => {
            let setor = setores.find(setor => setor['id_setor'] === avaliacao.id_setor).descricao;
            let codigoIdentificadorDispositivo = dispositivos.find(dispositivo => dispositivo['id_dispositivo'] === avaliacao.id_dispositivo).codigo_identificador;
    
            adicionarLinha(corpoTabela, [
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
}

// Sobreescrevendo metodo padrão
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
