<?php
// ============================================================
// criar_chamado.php
// Recebe os dados do formulário (frontend/index.html) e salva
// um novo chamado no banco de dados.
// ============================================================

// Só aceito quando vier de um formulário (POST).
// Se alguém abrir este arquivo direto no navegador, volta pro formulário.
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: /frontend/index.html");
    exit;
}

try {
    // 1. Conecta no banco (gera a variável $pdo)
    require_once __DIR__ . "/../config/conexao.php";

    // 2. Pega o que foi digitado no formulário
    //    (o trim tira espaços sobrando no começo e no fim)
    $nome_usuario = trim($_POST["nome_usuario"] ?? '');
    $titulo       = trim($_POST["titulo_chamado"] ?? '');
    $prioridade   = $_POST["prioridade_chamado"] ?? 'media';
    $descricao    = trim($_POST["descricao_chamado"] ?? '');

    // 3. Só aceito as prioridades que existem no select do formulário.
    //    Se vier qualquer outra coisa, vira "media".
    $prioridades_validas = ['alta', 'media', 'baixa'];
    if (!in_array($prioridade, $prioridades_validas)) {
        $prioridade = 'media';
    }

    // 4. Se algum campo obrigatório veio vazio, nem tenta salvar
    if ($nome_usuario === '' || $titulo === '' || $descricao === '') {
        http_response_code(400);
        die("Preencha todos os campos do chamado.");
    }

    // 5. Monta o INSERT usando "apelidos" (:titulo, :nome_usuario...)
    //    Isso protege contra SQL Injection, nunca juntar variável direto na query.
    $sql = "INSERT INTO chamados (nome_usuario, titulo, prioridade, descricao)
            VALUES (:nome_usuario, :titulo, :prioridade, :descricao)";
    $stmt = $pdo->prepare($sql);

    // 6. Executa trocando os apelidos pelos valores reais
    $stmt->execute([
        'nome_usuario' => $nome_usuario,
        'titulo'       => $titulo,
        'prioridade'   => $prioridade,
        'descricao'    => $descricao
    ]);

    // 7. Deu certo: volta pro formulário avisando que foi enviado
    //    (o index.js lê o ?sucesso=1 e mostra a mensagem)
    header("Location: /frontend/index.html?sucesso=1");
    exit;

} catch (PDOException $e) {
    // Mostro o erro na tela só porque ainda estou em fase de desenvolvimento.
    // Quando for pra produção, trocar por uma mensagem genérica.
    http_response_code(500);
    echo "Erro ao salvar no banco de dados: " . $e->getMessage();
}
