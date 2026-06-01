<?php

require_once "conexao.php";

header("Content-Type: application/json");

$descricao = trim($_POST["descricao"] ?? "");

if (!$descricao) {
    echo json_encode(["success" => false, "message" => "Informe a descrição do tipo de produto."]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO tbProdutoTipo (descricao) VALUES (?)");
$stmt->execute([$descricao]);

echo json_encode([
    "success" => true,
    "message" => "Tipo de produto cadastrado com sucesso.",
    "id" => (int)$pdo->lastInsertId()
]);
