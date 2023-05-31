<?php
function conectar() {
    try {
        $db_file = "C:\\xampp\\htdocs\\ado-php-2\\banco.sqlite";
        return new PDO("sqlite:$db_file");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        throw $e;
    }
}
?>