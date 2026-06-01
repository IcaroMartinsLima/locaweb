<?php

require_once "conexao.php";

header("Content-Type: application/json");

$id = trim($_POST["id"] ?? "");
$senha = $_POST["senha"] ?? "";

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID não informado."]);
    exit;
}

if (!$senha) {
    echo json_encode(["success" => false, "message" => "Informe sua senha para excluir a conta."]);
    exit;
}

$stmt = $pdo->prepare("SELECT usuario_id, senha FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    exit;
}

if (!password_verify($senha, $user["senha"])) {
    echo json_encode(["success" => false, "message" => "Senha incorreta."]);
    exit;
}

$stmt = $pdo->prepare("DELETE FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$id]);

echo json_encode(["success" => true]);
