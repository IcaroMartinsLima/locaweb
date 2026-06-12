<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$feedback_id = trim($_POST["feedback_id"] ?? "");
$cliente_id = trim($_POST["cliente_id"] ?? "");
$atualizado_por = trim($_POST["atualizado_por"] ?? "");

if (!$feedback_id) { echo json_encode(["success" => false, "message" => "Avaliação não informada."]); exit; }
if (!$cliente_id) { echo json_encode(["success" => false, "message" => "Cliente não informado."]); exit; }
if (!$atualizado_por) { echo json_encode(["success" => false, "message" => "Usuário não identificado."]); exit; }

$stmt = $pdo->prepare("SELECT cargo FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$atualizado_por]);
$user = $stmt->fetch();
if (!$user || $user["cargo"] === "Atendente") {
    echo json_encode(["success" => false, "message" => "Acesso não autorizado."]);
    exit;
}

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
