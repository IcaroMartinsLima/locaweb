<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$cliente_id = trim($_POST["cliente_id"] ?? "");
$produto_id = trim($_POST["produto_id"] ?? "");
$nota = trim($_POST["nota"] ?? "");
$observacao = trim($_POST["observacao"] ?? "");
$atualizado_por = trim($_POST["atualizado_por"] ?? "");

if (!$cliente_id) { echo json_encode(["success" => false, "message" => "Cliente não informado."]); exit; }
if (!$produto_id) { echo json_encode(["success" => false, "message" => "Produto não informado."]); exit; }
if (!$nota || $nota < 1 || $nota > 5) { echo json_encode(["success" => false, "message" => "A nota deve ser entre 1 e 5."]); exit; }
if (!$observacao) { echo json_encode(["success" => false, "message" => "Escreva um comentário."]); exit; }
if (!$atualizado_por) { echo json_encode(["success" => false, "message" => "Usuário não identificado."]); exit; }

$stmt = $pdo->prepare("SELECT cargo FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$atualizado_por]);
$user = $stmt->fetch();
if (!$user || $user["cargo"] === "Atendente") {
    echo json_encode(["success" => false, "message" => "Acesso não autorizado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT produto_id FROM tbProdutos WHERE produto_id = ?");
$stmt->execute([$produto_id]);
if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Produto não encontrado."]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO tbFeedBack (cliente_id, produto_id, nota, observacao, datahora, atualizado_por) VALUES (?, ?, ?, ?, CURTIME(), ?)");
$stmt->execute([$cliente_id, $produto_id, $nota, $observacao, $atualizado_por]);

echo json_encode([
    "success" => true,
    "message" => "Avaliação registrada com sucesso.",
    "feedback_id" => (int)$pdo->lastInsertId()
]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
