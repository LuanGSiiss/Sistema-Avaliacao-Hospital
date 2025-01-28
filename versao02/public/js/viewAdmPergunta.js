// Chamada Principal
document.getElementById("formularioPergunta").addEventListener("submit", function (event) {
    event.preventDefault();

    const dadosFormulario = new FormData(this);
    const func_assinc = new XMLHttpRequest();
    func_assinc.open("POST", "../src/controller_registro_pergunta.php", true);
    
    const p = document.getElementById('mensagem');
    p.textContent = "Enviando...";

    func_assinc.onload = function () {
        if (func_assinc.status === 200) {
            p.textContent = "Pergunta cadastrada com Sucesso...";
        } else {
            p.textContent = "Erro ao cadastrar pergunta...";
        }
    };
    
    func_assinc.send(dadosFormulario);
});