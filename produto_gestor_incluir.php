<?php

require_once "conexao.php";

header("Content-Type: application/json");

$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$produto_tipo_id = trim($_POST["produto_tipo_id"] ?? "");
$atualizado_por = trim($_POST["atualizado_por"] ?? "");

if (!$nome || !$descricao || !$produto_tipo_id || !$atualizado_por) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos."]);
    exit;
}

$stmt = $pdo->prepare("SELECT material_tipo_id FROM tbProdutoTipo WHERE material_tipo_id = ?");
$stmt->execute([$produto_tipo_id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Tipo de produto inválido."]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO tbProdutos (nome, descricao, produto_tipo_id, atualizado_por) VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $descricao, $produto_tipo_id, $atualizado_por]);

echo json_encode([
    "success" => true,
    "message" => "Produto cadastrado com sucesso.",
    "id" => (int)$pdo->lastInsertId()
]);
