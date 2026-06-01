<?php

require_once "conexao.php";

header("Content-Type: application/json");

$id = trim($_POST["id"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");

if (!$id || !$descricao) {
    echo json_encode(["success" => false, "message" => "ID e descrição são obrigatórios."]);
    exit;
}

$stmt = $pdo->prepare("SELECT material_tipo_id FROM tbProdutoTipo WHERE material_tipo_id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Tipo de produto não encontrado."]);
    exit;
}

$stmt = $pdo->prepare("UPDATE tbProdutoTipo SET descricao = ? WHERE material_tipo_id = ?");
$stmt->execute([$descricao, $id]);

echo json_encode(["success" => true, "message" => "Tipo de produto atualizado com sucesso."]);
