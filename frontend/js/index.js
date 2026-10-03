// ============================================================
// index.js
// Script da página do formulário (index.html).
// Só tem uma função: mostrar a mensagem de sucesso depois que
// o chamado foi salvo (o backend volta pra cá com ?sucesso=1).
// ============================================================

// Lê os parâmetros que vieram na URL
const params = new URLSearchParams(window.location.search);

if (params.get("sucesso") === "1") {
    // Tira o "hidden" da mensagem para ela aparecer
    document.getElementById("mensagem-sucesso").hidden = false;

    // Limpa o ?sucesso=1 da URL, assim a mensagem não volta se eu atualizar a página
    window.history.replaceState({}, "", window.location.pathname);
}
