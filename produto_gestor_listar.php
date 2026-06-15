<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$gestorId = $_GET["gestor_id"] ?? "";

if ($gestorId) {
    $stmt = $pdo->prepare("
        SELECT p.produto_id, p.nome, p.descricao, p.produto_tipo_id, t.descricao AS tipo_descricao, p.atualizado_em, p.atualizado_por
        FROM tbProdutos p
        LEFT JOIN tbProdutoTipo t ON p.produto_tipo_id = t.material_tipo_id
        WHERE p.atualizado_por = ?
        ORDER BY p.nome ASC
    ");
    $stmt->execute([$gestorId]);
} else {
    $stmt = $pdo->query("
        SELECT p.produto_id, p.nome, p.descricao, p.produto_tipo_id, t.descricao AS tipo_descricao, p.atualizado_em, p.atualizado_por
        FROM tbProdutos p
        LEFT JOIN tbProdutoTipo t ON p.produto_tipo_id = t.material_tipo_id
        ORDER BY p.nome ASC
    ");
}
$produtos = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "produtos" => $produtos
]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
