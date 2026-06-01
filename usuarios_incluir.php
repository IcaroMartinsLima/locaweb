<?php

require_once "conexao.php";

header("Content-Type: application/json");

$nome = trim($_POST["nome"] ?? "");
$login = trim($_POST["login"] ?? "");
$cargo = trim($_POST["cargo"] ?? "");
$senha = $_POST["senha"] ?? "";

if (!$nome || !$login || !$cargo || !$senha) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos."]);
    exit;
}

if (strlen($senha) < 4) {
    echo json_encode(["success" => false, "message" => "A senha deve ter pelo menos 4 caracteres."]);
    exit;
}

$stmt = $pdo->prepare("SELECT usuario_id FROM tbUsuarios WHERE login = ?");
$stmt->execute([$login]);

if ($stmt->fetch()) {
    echo json_encode(["success" => false, "message" => "Este email já está cadastrado."]);
    exit;
}

$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO tbUsuarios (nome, login, cargo, senha) VALUES (?, ?, ?, ?)");
$stmt->execute([$nome, $login, $cargo, $senhaHash]);

$novoId = $pdo->lastInsertId();

echo json_encode([
    "success" => true,
    "user" => [
        "id" => (int)$novoId,
        "name" => $nome,
        "email" => $login,
        "cargo" => $cargo
    ]
]);
