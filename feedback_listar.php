<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$cliente_id = trim($_GET["cliente_id"] ?? $_POST["cliente_id"] ?? "");

if (!$cliente_id) {
    echo json_encode(["success" => false, "message" => "Cliente não informado."]);
    exit;
}

$stmt = $pdo->prepare("
    SELECT f.feedback_id, f.cliente_id, f.produto_id, f.nota, f.observacao, f.datahora, f.atualizado_por,
           p.nome AS produto_nome, p.descricao AS produto_descricao
    FROM tbFeedBack f
    INNER JOIN tbProdutos p ON f.produto_id = p.produto_id
    WHERE f.cliente_id = ?
    ORDER BY f.feedback_id DESC
");
$stmt->execute([$cliente_id]);
$feedbacks = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "feedbacks" => $feedbacks
]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
