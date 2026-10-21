// Protege contra XSS ao colocar texto dentro de innerHTML
function esc(texto) {
    return String(texto).replace(/[&<>"']/g, c => '&#' + c.charCodeAt(0) + ';');
}

function mensagem(texto) {
    document.getElementById('mensagem').textContent = texto;
}

// O carrinho é um objeto: { id: { nome, preco, qtd } }
function lerCarrinho() {
    return JSON.parse(localStorage.getItem('carrinho')) || {};
}

function adicionar(id, nome, preco) {
    const carrinho = lerCarrinho();
    if (!carrinho[id]) {
        carrinho[id] = { nome: nome, preco: preco, qtd: 0 };
    }
    carrinho[id].qtd++;
    localStorage.setItem('carrinho', JSON.stringify(carrinho));
    alert('Adicionado ao carrinho!');
}

function mostrarCarrinho() {
    const carrinho = lerCarrinho();
    let linhas = '';
    let total = 0;

    for (const id in carrinho) {
        const item = carrinho[id];
        const subtotal = item.preco * item.qtd;
        total += subtotal;
        linhas += `<tr>
            <td>${esc(item.nome)}</td>
            <td>${item.qtd}</td>
            <td>R$ ${subtotal.toFixed(2)}</td>
        </tr>`;
    }

    document.getElementById('lista').innerHTML = linhas;
    document.getElementById('total').textContent = total.toFixed(2);
}

async function finalizar() {
    const carrinho = lerCarrinho();

    // Enviamos só { id: quantidade }. O preço quem busca é o servidor.
    const itens = {};
    for (const id in carrinho) {
        itens[id] = carrinho[id].qtd;
    }

    // Validação no front-end
    if (Object.keys(itens).length === 0) {
        mensagem('Carrinho vazio.');
        return;
    }

    const dados = new FormData();
    dados.append('itens', JSON.stringify(itens));

    const resposta = await fetch('finalizar_pedido.php', { method: 'POST', body: dados });
    const texto = await resposta.text();
    
        if (texto === 'login') {
        window.location.href = 'login.php';   // não está logado: manda para o login
        return;
    }

    if (texto === 'ok') {
        localStorage.removeItem('carrinho');
        mostrarCarrinho();
        mensagem('Pedido realizado com sucesso!');
    } else {
        mensagem(texto);
    }
}

// Na vitrine: botões "Adicionar ao Carrinho"
document.querySelectorAll('.btn-add').forEach(botao => {
    botao.addEventListener('click', () => {
        adicionar(botao.dataset.id, botao.dataset.nome, Number(botao.dataset.preco));
    });
});

// Na página do carrinho
if (document.getElementById('lista')) {
    mostrarCarrinho();
    document.getElementById('btn-finalizar').addEventListener('click', finalizar);
}