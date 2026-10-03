<?php
// ============================================================
// listar_chamados.php
// Busca todos os chamados no banco e devolve em formato JSON.
// Quem usa este arquivo é o frontend/js/listar.js (via fetch),
// que desenha a tabela na tela.
// ============================================================

// Avisa o navegador que a resposta é JSON
header("Content-Type: application/json; charset=utf-8");

try {
    // 1. Conecta no banco (gera a variável $pdo)
    require_once __DIR__ . "/../config/conexao.php";

    // 2. Busca os chamados, do mais novo para o mais antigo.
    //    O DATE_FORMAT já entrega a data no formato brasileiro (dd/mm/aaaa hh:mm),
    //    assim o frontend não precisa se preocupar com isso.
    $sql = "SELECT id, nome_usuario, titulo, prioridade, descricao, status,
                   DATE_FORMAT(data_criacao, '%d/%m/%Y %H:%i') AS data_criacao
            FROM chamados
            ORDER BY id DESC";
    $chamados = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

    // 3. Devolve a lista em JSON (o UNESCAPED_UNICODE mantém os acentos certinhos)
    echo json_encode($chamados, JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    // Se der erro, devolve o código 500 e a mensagem em JSON
    http_response_code(500);
    echo json_encode(["erro" => "Erro ao buscar dados: " . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
