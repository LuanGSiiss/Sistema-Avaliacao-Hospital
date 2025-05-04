// Ajuste do textarea
const textarea = document.getElementById("texto_pergunta");
const butaoEnviar = document.getElementById("enviar");

textarea.addEventListener("input", function () {
    this.style.height = "auto"; // Reseta a altura para evitar crescimento infinito
    this.style.height = this.scrollHeight + "px"; // Define a nova altura com base no conteúdo
    
    if (textarea.value.trim() !== '') {
        butaoEnviar.disabled = false;
    } else {
        butaoEnviar.disabled = true;
    }
});

function contagemCaracteres() {
    let count = document.getElementById("contadorChar");
    count.textContent = `${textarea.value.length}/350 caracteres`;
    if (textarea.value.length == 350) {
        count.style.color = "red";
    } else {
        count.style.color = "black";
    }
}


// Chamada Principal do formulario
document.getElementById("formularioPergunta").addEventListener("submit", function (event) {
    event.preventDefault();

    const dadosFormulario = new FormData(this);
    const func_assinc = new XMLHttpRequest();
    func_assinc.open("POST", "../controller/controller_registro_pergunta.php", true);
    
    const p = document.getElementById('mensagem');
    p.textContent = "Enviando...";

    func_assinc.onload = function () {
        const retornoMensagem = JSON.parse(func_assinc.responseText);

        if (func_assinc.status === 200) {
            p.textContent = retornoMensagem.mensagem;
        } else {
            p.textContent = retornoMensagem.mensagem;
        }
    };
    
    func_assinc.send(dadosFormulario);
});