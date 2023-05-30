<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";

$numero = (int) $_POST["numero"];
$id = excluir_quarto($numero);

header("Location: listagem.php");

$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>