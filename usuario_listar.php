<?php

require_once "conexao.php";

header("Content-Type: application/json");

$stmt = $pdo->query("SELECT usuario_id, nome, login, atualizado_em FROM tbUsuarios ORDER BY nome ASC");
$usuarios = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "usuarios" => $usuarios
]);
