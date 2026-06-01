<?php

require_once "conexao.php";

header("Content-Type: application/json");

$id = trim($_POST["id"] ?? "");
$nome = trim($_POST["nome"] ?? "");
$login = trim($_POST["login"] ?? "");
$senhaAtual = $_POST["senha_atual"] ?? "";
$novaSenha = $_POST["nova_senha"] ?? "";

if (!$id) {
    echo json_encode(["success" => false, "message" => "ID não informado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT usuario_id, nome, login, senha FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    echo json_encode(["success" => false, "message" => "Usuário não encontrado."]);
    exit;
}

if (!password_verify($senhaAtual, $user["senha"])) {
    echo json_encode(["success" => false, "message" => "Senha atual incorreta."]);
    exit;
}

if ($login && $login !== $user["login"]) {
    $stmt = $pdo->prepare("SELECT usuario_id FROM tbUsuarios WHERE login = ? AND usuario_id != ?");
    $stmt->execute([$login, $id]);
    if ($stmt->fetch()) {
        echo json_encode(["success" => false, "message" => "Este email já está em uso."]);
        exit;
    }
}

$fields = [];
$params = [];

if ($nome && $nome !== $user["nome"]) {
    $fields[] = "nome = ?";
    $params[] = $nome;
}

if ($login && $login !== $user["login"]) {
    $fields[] = "login = ?";
    $params[] = $login;
}

if ($novaSenha) {
    if (strlen($novaSenha) < 4) {
        echo json_encode(["success" => false, "message" => "A nova senha deve ter pelo menos 4 caracteres."]);
        exit;
    }
    $fields[] = "senha = ?";
    $params[] = password_hash($novaSenha, PASSWORD_DEFAULT);
}

if (empty($fields)) {
    echo json_encode(["success" => false, "message" => "Nenhum dado para alterar."]);
    exit;
}

$params[] = $id;
$sql = "UPDATE tbUsuarios SET " . implode(", ", $fields) . " WHERE usuario_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);

$stmt = $pdo->prepare("SELECT usuario_id, nome, login FROM tbUsuarios WHERE usuario_id = ?");
$stmt->execute([$id]);
$updated = $stmt->fetch();

echo json_encode([
    "success" => true,
    "user" => [
        "id" => (int)$updated["usuario_id"],
        "name" => $updated["nome"],
        "email" => $updated["login"]
    ]
]);
