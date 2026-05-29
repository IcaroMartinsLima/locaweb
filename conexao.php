<?php

$host = "savir082bd.vpshost12372.mysql.dbaas.com.br";
$usuario = "savir082bd";
$senha = "savir082#BD";
$banco = "savir082bd";

$conexao = new mysqli(
    $host,
    $usuario,
    $senha,
    $banco
);

if ($conexao->connect_error) {

    die(
        "Erro de conexão: " .
        $conexao->connect_error
    );
}

$conexao->set_charset("utf8mb4");