<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$usuario_id = trim($_POST["usuario_id"] ?? "");
$nome = trim($_POST["nome"] ?? "");
$cpf = trim($_POST["cpf"] ?? "");
$nascimento = trim($_POST["nascimento"] ?? "");
$telefone = trim($_POST["telefone"] ?? "");

if (!$usuario_id) { echo json_encode(["success" => false, "message" => "Usuário não informado."]); exit; }
if (!$nome) { echo json_encode(["success" => false, "message" => "Informe o nome."]); exit; }
if (!$cpf) { echo json_encode(["success" => false, "message" => "Informe o CPF."]); exit; }
if (!$nascimento) { echo json_encode(["success" => false, "message" => "Informe a data de nascimento."]); exit; }
if (!$telefone) { echo json_encode(["success" => false, "message" => "Informe o telefone."]); exit; }

$stmt = $pdo->prepare("SELECT pessoa_id FROM tbPessoas WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
if ($stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Cliente já cadastrado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT pessoa_id FROM tbPessoas WHERE cpf = ?");
$stmt->execute([$cpf]);
if ($stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "CPF já cadastrado."]);
    exit;
}

$stmt = $pdo->prepare("INSERT INTO tbPessoas (nome, cpf, nascimento, telefone, usuario_id, atualizado_por, atualizado_em) VALUES (?, ?, ?, ?, ?, ?, CURDATE())");
$stmt->execute([$nome, $cpf, $nascimento, $telefone, $usuario_id, $usuario_id]);

echo json_encode([
    "success" => true,
    "message" => "Cliente cadastrado com sucesso.",
    "pessoa_id" => (int)$pdo->lastInsertId()
]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
