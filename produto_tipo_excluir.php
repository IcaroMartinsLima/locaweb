<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$id = trim($_POST["id"] ?? "");

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID não informado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT material_tipo_id FROM tbProdutoTipo WHERE material_tipo_id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Tipo de produto não encontrado."]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM tbProdutoTipo WHERE material_tipo_id = ?");
$stmt->execute([$id]);

echo json_encode(["success" => true, "message" => "Tipo de produto excluído com sucesso."]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
