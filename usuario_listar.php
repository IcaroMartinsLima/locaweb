<?php

require_once "conexao.php";

header("Content-Type: application/json");

$login = trim($_POST["login"] ?? "");
$senha = $_POST["senha"] ?? "";

if ($login && $senha) {
    $stmt = $pdo->prepare("SELECT usuario_id, nome, login, cargo, senha, atualizado_em FROM tbUsuarios WHERE login = ?");
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($senha, $user["senha"])) {
        echo json_encode(["success" => false, "message" => "Email ou senha inválidos."]);
        exit;
    }

    echo json_encode([
        "success" => true,
        "user" => [
            "id" => (int)$user["usuario_id"],
            "name" => $user["nome"],
            "email" => $user["login"],
            "cargo" => $user["cargo"]
        ]
    ]);
    exit;
}

$stmt = $pdo->query("SELECT usuario_id, nome, login, cargo, atualizado_em FROM tbUsuarios ORDER BY nome ASC");
$usuarios = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "usuarios" => $usuarios
]);
