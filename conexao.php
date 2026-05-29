<?php

$host = "savir082bd.vpshost12372.mysql.dbaas.com.br";
$dbname = "savir082bd";
$username = "savir082bd";
$password = "savir082#BD";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
