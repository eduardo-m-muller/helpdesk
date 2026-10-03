// ============================================================
// listar.js
// Script da página do painel (listar.html).
// Busca os chamados no backend e monta as linhas da tabela.
// ============================================================

// Endereço do backend que devolve os chamados em JSON
const URL_API = "/backend/api/listar_chamados.php";

// Onde as linhas vão ser colocadas
const corpoTabela = document.getElementById("lista-chamados");

// Prioridades que têm cor definida no CSS (alta, media, baixa)
const PRIORIDADES = ["alta", "media", "baixa"];

// Cria uma célula <td> com um texto dentro.
// Uso textContent (e não innerHTML) de propósito: assim qualquer
// HTML digitado pelo usuário aparece como texto e não é executado.
function criarCelula(texto) {
    const td = document.createElement("td");
    td.textContent = texto;
    return td;
}

// Mostra uma mensagem ocupando a tabela inteira
// (usada para "nenhum chamado" e para erros)
function mostrarMensagem(texto) {
    corpoTabela.innerHTML = "";
    const tr = document.createElement("tr");
    const td = criarCelula(texto);
    td.colSpan = 7;
    td.className = "centralizado";
    tr.appendChild(td);
    corpoTabela.appendChild(tr);
}

// Monta uma linha da tabela para cada chamado
function criarLinha(chamado) {
    const tr = document.createElement("tr");

    // ID e nome
    tr.appendChild(criarCelula("#" + chamado.id));
    tr.appendChild(criarCelula(chamado.nome_usuario));
    tr.appendChild(criarCelula(chamado.titulo));

    // Prioridade: vira uma "etiqueta" colorida (badge)
    const tdPrioridade = document.createElement("td");
    const badge = document.createElement("span");
    const prioridade = chamado.prioridade.toLowerCase();
    badge.className = "badge" + (PRIORIDADES.includes(prioridade) ? " " + prioridade : "");
    badge.textContent = chamado.prioridade;
    tdPrioridade.appendChild(badge);
    tr.appendChild(tdPrioridade);

    // Descrição (a quebra de linha é tratada no CSS, com white-space: pre-line)
    const tdDescricao = criarCelula(chamado.descricao);
    tdDescricao.className = "descricao";
    tr.appendChild(tdDescricao);

    // Status em negrito
    const tdStatus = document.createElement("td");
    const negrito = document.createElement("strong");
    negrito.textContent = chamado.status;
    tdStatus.appendChild(negrito);
    tr.appendChild(tdStatus);

    // Data (o backend já manda formatada)
    tr.appendChild(criarCelula(chamado.data_criacao));

    return tr;
}

// Busca os chamados no backend e desenha a tabela
async function carregarChamados() {
    try {
        const resposta = await fetch(URL_API);
        const dados = await resposta.json();

        // Se o backend avisou que deu erro, mostra a mensagem dele
        if (!resposta.ok) {
            mostrarMensagem(dados.erro || "Erro ao buscar os chamados.");
            return;
        }

        // Nenhum chamado cadastrado ainda
        if (dados.length === 0) {
            mostrarMensagem("Nenhum chamado encontrado.");
            return;
        }

        // Limpa o "Carregando..." e coloca uma linha por chamado
        corpoTabela.innerHTML = "";
        dados.forEach(chamado => corpoTabela.appendChild(criarLinha(chamado)));

    } catch (erro) {
        // Cai aqui se o servidor estiver fora do ar, por exemplo
        mostrarMensagem("Não consegui falar com o servidor.");
    }
}

// Roda assim que a página abre
carregarChamados();
