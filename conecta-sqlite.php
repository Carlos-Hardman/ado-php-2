<?php
function conectar() {
    try {
        $db_file = "C:\\xampp\\htdocs\\ADO-PHP-2\\conexao.sqlite";
        return new PDO("sqlite:$db_file");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        throw $e;
    }
}
?>