<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$stmt = $pdo->query("SELECT material_tipo_id, descricao FROM tbProdutoTipo ORDER BY descricao ASC");
$tipos = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "tipos" => $tipos
]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
