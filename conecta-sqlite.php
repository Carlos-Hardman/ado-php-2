<?php
function conectar() {
    try {
        $db_file = "C:\\xampp\htdocs\\ado-php-2\\conexao.sql";
        return new PDO("sqlite:$db_file");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        throw $e;
    }
}
?>