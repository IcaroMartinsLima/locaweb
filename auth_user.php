<?php

require_once "conexao.php";

header("Content-Type: application/json");

$id = $_GET["id"] ?? "";

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID não informado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT usuario_id, nome, login, atualizado_em FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if ($user) {
    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user["usuario_id"],
            "name" => $user["nome"],
            "email" => $user["login"],
            "createdAt" => $user["atualizado_em"]
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
}
