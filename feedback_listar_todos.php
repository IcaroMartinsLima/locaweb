<?php

require_once "conexao.php";

header("Content-Type: application/json");

try {

$stmt = $pdo->prepare("
    SELECT f.feedback_id, f.cliente_id, f.produto_id, f.nota, f.observacao, f.datahora,
           p.nome AS produto_nome, p.descricao AS produto_descricao,
           pe.nome AS avaliador_nome
    FROM tbFeedBack f
    INNER JOIN tbProdutos p ON f.produto_id = p.produto_id
    LEFT JOIN tbPessoas pe ON f.cliente_id = pe.pessoa_id
    ORDER BY f.feedback_id DESC
");
$stmt->execute();
$feedbacks = $stmt->fetchAll();

echo json_encode([
    "success" => true,
    "feedbacks" => $feedbacks
]);

} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erro no banco de dados: " . $e->getMessage()]);
}
