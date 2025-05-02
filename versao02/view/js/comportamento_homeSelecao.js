const func_assinc = new XMLHttpRequest();
func_assinc.open("GET", "../routes/routes.php?action=busca_setores", true);
func_assinc.onload = function () {
    if (func_assinc.status === 200) {
        try {
            const stringJSON = func_assinc.responseText;
            const selectSetores = document.getElementById('setores');
            
            const conteudo = JSON.parse(stringJSON);

            if (!conteudo || !conteudo.setores || conteudo.setores.length === 0) {
                console.log("Nenhum Setor encontrado");
            } else {
                conteudo.setores.forEach( setor => {
                    criaOp(setor[0], setor[1], selectSetores);    
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


const criaOp = (id, valor, select) => {
    const option = document.createElement('option')
    option.value = id
    option.textContent = valor
    select.appendChild(option)
}

//------------------------------------

// Controle da ativação e desativação do link para a pagina de avaliação || Atualização do link para a pagina de avaliação
const link = document.getElementById('link-avaliacao');
const selectSetores = document.getElementById('setores');

function atualizarLink() {

    if (selectSetores.value === "") {
        link.addEventListener('click', impedirClique);
        link.style.pointerEvents = "none";
        link.style.opacity = "0.5";
    } else {
        link.removeEventListener('click', impedirClique);
        link.style.pointerEvents = "auto";
        link.style.opacity = "1";
        link.href = `../routes/routes.php?action=pag_consulta_avaliacoes&id_setor=${encodeURIComponent(selectSetores.value)}`;
    }
}

function impedirClique(event) {
    event.preventDefault();
}

selectSetores.addEventListener('change', atualizarLink);

atualizarLink();
