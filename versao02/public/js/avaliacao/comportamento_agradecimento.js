let tempoRecarga = 5;

function atualizarRecarga() {
    const contador = document.getElementById('contador');
    contador.textContent = tempoRecarga;

    if (tempoRecarga === 0) {
        window.location.href = document.referrer;
    } else {
        tempoRecarga--;
        setTimeout(atualizarRecarga, 1000);
    }
}

window.onload = atualizarRecarga;