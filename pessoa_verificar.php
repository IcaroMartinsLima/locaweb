<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$usuario_id = trim($_POST["usuario_id"] ?? $_GET["usuario_id"] ?? "");

if (!$usuario_id) {
    echo json_encode(["success" => false, "message" => "Usuário não informado."]);
    exit;
}

$stmt = $pdo->prepare("SELECT pessoa_id, nome, cpf, nascimento, telefone FROM tbPessoas WHERE usuario_id = ?");
$stmt->execute([$usuario_id]);
$pessoa = $stmt->fetch();

if ($pessoa) {
    echo json_encode([
        "success" => true,
        "existe" => true,
        "pessoa" => [
            "pessoa_id" => (int)$pessoa["pessoa_id"],
            "nome" => $pessoa["nome"],
            "cpf" => $pessoa["cpf"],
            "nascimento" => $pessoa["nascimento"],
            "telefone" => $pessoa["telefone"]
        ]
    ]);
} else {
    echo json_encode(["success" => true, "existe" => false]);
}

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
