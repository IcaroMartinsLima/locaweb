<?php

require_once "conexao.php";

header("Content-Type: application/json");

$id = trim($_POST["id"] ?? "");

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID não informado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT produto_id FROM tbProdutos WHERE produto_id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Produto não encontrado."]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM tbProdutos WHERE produto_id = ?");
$stmt->execute([$id]);

echo json_encode(["success" => true, "message" => "Produto excluído com sucesso."]);
