<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$id = trim($_POST["id"] ?? "");
$nome = trim($_POST["nome"] ?? "");
$descricao = trim($_POST["descricao"] ?? "");
$produto_tipo_id = trim($_POST["produto_tipo_id"] ?? "");
$atualizado_por = trim($_POST["atualizado_por"] ?? "");

if (!$id) { echo json_encode(["success" => false, "message" => "ID não informado."]); exit; }
if (!$nome) { echo json_encode(["success" => false, "message" => "Informe o nome do produto."]); exit; }
if (!$descricao) { echo json_encode(["success" => false, "message" => "Informe a descrição do produto."]); exit; }
if (!$produto_tipo_id) { echo json_encode(["success" => false, "message" => "Selecione o tipo do produto."]); exit; }
if (!$atualizado_por) { echo json_encode(["success" => false, "message" => "Usuário não identificado."]); exit; }

$stmt = $pdo->prepare("SELECT produto_id FROM tbProdutos WHERE produto_id = ?");
$stmt->execute([$id]);

if (!$stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Produto não encontrado."]);
    exit;
}

$stmt = $pdo->prepare("UPDATE tbProdutos SET nome = ?, descricao = ?, produto_tipo_id = ?, atualizado_por = ?, atualizado_em = CURTIME() WHERE produto_id = ?");
$stmt->execute([$nome, $descricao, $produto_tipo_id, $atualizado_por, $id]);

echo json_encode(["success" => true, "message" => "Produto atualizado com sucesso."]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
