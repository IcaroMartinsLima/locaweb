<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$feedback_id = trim($_POST["feedback_id"] ?? "");
$cliente_id = trim($_POST["cliente_id"] ?? "");
$nota = trim($_POST["nota"] ?? "");
$observacao = trim($_POST["observacao"] ?? "");
$atualizado_por = trim($_POST["atualizado_por"] ?? "");

if (!$feedback_id) { echo json_encode(["success" => false, "message" => "Avaliação não informada."]); exit; }
if (!$cliente_id) { echo json_encode(["success" => false, "message" => "Cliente não informado."]); exit; }
if (!$nota || $nota < 1 || $nota > 5) { echo json_encode(["success" => false, "message" => "A nota deve ser entre 1 e 5."]); exit; }
if (!$observacao) { echo json_encode(["success" => false, "message" => "Escreva um comentário."]); exit; }
if (!$atualizado_por) { echo json_encode(["success" => false, "message" => "Usuário não identificado."]); exit; }

$stmt = $pdo->prepare("SELECT feedback_id FROM tbFeedBack WHERE feedback_id = ? AND cliente_id = ?");
$stmt->execute([$feedback_id, $cliente_id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Avaliação não encontrada ou não pertence a você."]);
    exit;
}

$stmt = $pdo->prepare("UPDATE tbFeedBack SET nota = ?, observacao = ?, atualizado_por = ? WHERE feedback_id = ?");
$stmt->execute([$nota, $observacao, $atualizado_por, $feedback_id]);

echo json_encode(["success" => true, "message" => "Avaliação atualizada com sucesso."]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
