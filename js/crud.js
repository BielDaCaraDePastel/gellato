let produtos = [];
let categorias = [];
let clientes = [];   // NOVO

function esc(texto) {
    return String(texto).replace(/[&<>"']/g, c => '&#' + c.charCodeAt(0) + ';');
}

function mensagem(texto) {
    document.getElementById('mensagem').textContent = texto;
}

// Busca os dados no PHP e redesenha as tabelas (sem recarregar a página)
async function carregarTudo() {
    categorias = await (await fetch('categorias_listar.php')).json();
    produtos = await (await fetch('produtos_listar.php')).json();
    clientes = await (await fetch('clientes_listar.php')).json();  

    let linhasCat = '';
    let opcoes = '<option value="">Sem categoria</option>';
    categorias.forEach(c => {
        opcoes += `<option value="${c.id}">${esc(c.nome)}</option>`;
        linhasCat += `<tr>
            <td>${c.id}</td>
            <td>${esc(c.nome)}</td>
            <td>
                <button onclick="editarCategoria(${c.id})">Editar</button>
                <button class="perigo" onclick="excluir('categorias_excluir.php', ${c.id})">Excluir</button>
            </td>
        </tr>`;
    });
    document.getElementById('tabela-categorias').innerHTML = linhasCat;
    document.getElementById('select-categoria').innerHTML = opcoes;

    let linhasProd = '';
    produtos.forEach(p => {
        linhasProd += `<tr>
            <td>${p.id}</td>
            <td>${esc(p.nome)}</td>
            <td>${esc(p.categoria || '-')}</td>
            <td>R$ ${Number(p.preco).toFixed(2)}</td>
            <td>${p.estoque}</td>
            <td>
                <button onclick="editarProduto(${p.id})">Editar</button>
                <button class="perigo" onclick="excluir('produtos_excluir.php', ${p.id})">Excluir</button>
            </td>
        </tr>`;
    });
    document.getElementById('tabela-produtos').innerHTML = linhasProd;

    let linhasCli = '';
    clientes.forEach(c => {
        linhasCli += `<tr>
            <td>${c.id}</td>
            <td>${esc(c.nome)}</td>
            <td>${esc(c.email)}</td>
            <td>
                <button onclick="editarCliente(${c.id})">Editar</button>
                <button class="perigo" onclick="excluir('clientes_excluir.php', ${c.id})">Excluir</button>
            </td>
        </tr>`;
    });
    document.getElementById('tabela-clientes').innerHTML = linhasCli;
}

// Envia um FormData para o PHP e devolve a resposta em texto
async function enviar(url, dados) {
    const resposta = await fetch(url, { method: 'POST', body: dados });
    return await resposta.text();
}

// Serve para produtos, categorias E clientes
async function salvar(evento, url) {
    evento.preventDefault();
    const form = evento.target;

    // Validação no front-end
    if (form.elements['nome'].value.trim() === '') {
        mensagem('Preencha o nome.');
        return;
    }

    const resposta = await enviar(url, new FormData(form));

    if (resposta === 'ok') {
        mensagem('Salvo com sucesso!');
        form.reset();
        form.elements['id'].value = '';
        carregarTudo();
    } else {
        mensagem(resposta);
    }
}

// Serve para produtos, categorias E clientes
async function excluir(url, id) {
    if (!confirm('Tem certeza que deseja excluir?')) return;

    const dados = new FormData();
    dados.append('id', id);
    const resposta = await enviar(url, dados);

    mensagem(resposta === 'ok' ? 'Excluído com sucesso!' : resposta);
    carregarTudo();
}

// Coloca os dados de um registro dentro do formulário para editar
function preencher(idForm, registro) {
    const form = document.getElementById(idForm);
    for (const campo in registro) {
        if (form.elements[campo]) {
            form.elements[campo].value = registro[campo] ?? '';
        }
    }
}

function editarProduto(id) {
    preencher('form-produto', produtos.find(p => p.id == id));
}

function editarCategoria(id) {
    preencher('form-categoria', categorias.find(c => c.id == id));
}

function editarCliente(id) {
    preencher('form-cliente', clientes.find(c => c.id == id));
}

document.getElementById('form-produto').addEventListener('submit', e => salvar(e, 'produtos_salvar.php'));
document.getElementById('form-categoria').addEventListener('submit', e => salvar(e, 'categorias_salvar.php'));
document.getElementById('form-cliente').addEventListener('submit', e => salvar(e, 'clientes_salvar.php'));   // NOVO

carregarTudo();