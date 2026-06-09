<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$feedback_id = trim($_POST["feedback_id"] ?? "");
$cliente_id = trim($_POST["cliente_id"] ?? "");

if (!$feedback_id) { echo json_encode(["success" => false, "message" => "Avaliação não informada."]); exit; }
if (!$cliente_id) { echo json_encode(["success" => false, "message" => "Cliente não informado."]); exit; }

$stmt = $pdo->prepare("SELECT feedback_id FROM tbFeedBack WHERE feedback_id = ? AND cliente_id = ?");
$stmt->execute([$feedback_id, $cliente_id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Avaliação não encontrada ou não pertence a você."]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM tbFeedBack WHERE feedback_id = ?");
$stmt->execute([$feedback_id]);

echo json_encode(["success" => true, "message" => "Avaliação excluída com sucesso."]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
