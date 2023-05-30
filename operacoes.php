<?php

include_once "conecta-sqlite.php";

function inserir_quarto($quarto) {
    global $pdo;
    $sql = "INSERT INTO quarto (camas_solteiro, camas_casal, area_m2, reservado, valor_diaria) " .
            "VALUES (:camas_solteiro, :camas_casal, :area_m2, :reservado, :valor_diaria)";
    $pdo->prepare($sql)->execute($quarto);
    return $pdo->lastInsertId();
}

function alterar_quarto($quarto) {
    global $pdo;
    $sql = "UPDATE quarto SET " .
            "camas_solteiro = :camas_solteiro, " .
            "camas_casal = :camas_casal, " .
            "area_m2 = :area_m2, ".
            "reservado = :reservado, " .
            "valor_diaria = :valor_diaria " .
            "WHERE numero = :numero";
    $pdo->prepare($sql)->execute($quarto);
}

function excluir_quarto($numero) {
    global $pdo;
    $sql = "DELETE FROM quarto WHERE numero = :numero";
    $pdo->prepare($sql)->execute(["numero" => $numero]);
}

function listar_todos_quarto() {
    global $pdo;
    $sql = "SELECT * FROM quarto";
    $resultados = [];
    $consulta = $pdo->query($sql);
    while ($linha = $consulta->fetch()) {
        $resultados[] = $linha;
    }
    return $resultados;
}

function buscar_quarto($numero) {
    global $pdo;
    $sql = "SELECT * FROM quarto WHERE numero = :numero";
    $resultados = [];
    $consulta = $pdo->prepare($sql);
    $consulta->execute(["numero" => $numero]);
    return $consulta->fetch();
}

