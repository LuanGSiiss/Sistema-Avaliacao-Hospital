// Ajuste do textarea
const textarea = document.getElementById('texto_pergunta');
const todosSetores = document.getElementById('todos_setores');
const selectSetores = document.getElementById('setores');

textarea.addEventListener("input", function () {
    this.style.height = "auto";
    this.style.height = this.scrollHeight + "px"; 
});

// Para vir desabilitado ou habilitado na alteração
if (todosSetores.checked) {
        selectSetores.disabled = true;
    } else {
        selectSetores.disabled = false;
    }

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
