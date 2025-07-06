// Ajuste do textarea
const textarea = document.getElementById('texto_pergunta');
const todosSetores = document.getElementById('todos_setores');
const selectSetores = document.getElementById('setores');
const butaoEnviar = document.getElementById('enviar');

textarea.addEventListener("input", function () {
    this.style.height = "auto"; // Reseta a altura para evitar crescimento infinito
    this.style.height = this.scrollHeight + "px"; // Define a nova altura com base no conteúdo
    
    if (textarea.value.trim() !== '') {
        butaoEnviar.disabled = false;
    } else {
        butaoEnviar.disabled = true;
    }
});

todosSetores.addEventListener("change", function () {
    if (todosSetores.checked) {
        selectSetores.disabled = true;
    } else {
        selectSetores.disabled = false;
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
