function mensagem(texto) {
    document.getElementById('mensagem').textContent = texto;
}

// Serve para os dois formulários: só muda a URL de destino
async function enviar(evento, url) {
    evento.preventDefault();

    const resposta = await fetch(url, { method: 'POST', body: new FormData(evento.target) });
    const texto = await resposta.text();

    if (texto === 'ok') {
        window.location.href = 'index.php';
    } else {
        mensagem(texto);
    }
}

document.getElementById('form-login').addEventListener('submit', e => enviar(e, 'login_entrar.php'));
document.getElementById('form-cadastro').addEventListener('submit', e => enviar(e, 'login_cadastrar.php'));