<?php

require_once "conexao.php";

header("Content-Type: application/json");

$stmt = $pdo->query("SELECT material_tipo_id, descricao FROM tbProdutoTipo ORDER BY descricao ASC");
$tipos = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "tipos" => $tipos
]);
