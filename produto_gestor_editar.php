<?php

require_once "conexao.php";

header("Content-Type: application/json");

$id = trim($_POST["id"] ?? "");
$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$produto_tipo_id = trim($_POST["produto_tipo_id"] ?? "");

if (!$id || !$nome || !$descricao || !$produto_tipo_id) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos."]);
    exit;
}

$stmt = $pdo->prepare("SELECT produto_id FROM tbProdutos WHERE produto_id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Produto não encontrado."]);
    exit;
}

$stmt = $pdo->prepare("UPDATE tbProdutos SET nome = ?, descricao = ?, produto_tipo_id = ? WHERE produto_id = ?");
$stmt->execute([$nome, $descricao, $produto_tipo_id, $id]);

echo json_encode(["success" => true, "message" => "Produto atualizado com sucesso."]);
