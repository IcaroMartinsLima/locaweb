<?php

require_once "conexao.php";

header("Content-Type: application/json");

$login = $_POST["login"] ?? "";
$senha = $_POST["senha"] ?? "";

if (!$login || !$senha) {
    echo json_encode(["success" => false, "message" => "Preencha todos os campos."]);
    exit;
}

$stmt = $pdo->prepare("SELECT usuario_id, nome, login, senha FROM tbUsuarios WHERE login = ?");
$stmt->execute([$login]);
$user = $stmt->fetch();

$senhaValida = password_verify($senha, $user["senha"]) || $senha === $user["senha"];

if ($user && $senhaValida) {
    echo json_encode([
        "success" => true,
        "user" => [
            "id" => $user["usuario_id"],
            "name" => $user["nome"],
            "email" => $user["login"]
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Credenciais inválidas."]);
}
