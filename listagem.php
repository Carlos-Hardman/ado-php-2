<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";


?>
<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="utf-8">
        <title>Listagem de flores</title>
    </head>
    <body>
        <?php $resultado = listar_todos_quarto(); ?>
        <table>
            <tr>
                <th scope="column">numero</th>
                <th scope="column">cama solteiro</th>
                <th scope="column">camas casal</th>
                <th scope="column">area m2</th>
                <th scope="column">reservado</th>
                <th scope="column">valor diaria</th>
                <th scope="column"></th>
                <th scope="column"></th>
            </tr>
            <?php foreach ($resultado as $linha) { ?>
                <tr>
                    <td><?= $linha["numero"] ?></td>
                    <td><?= $linha["camas_solteiro"] ?></td>
                    <td><?= $linha["camas_casal"] ?></td>
                    <td><?= $linha["area_m2"] ?></td>
                    <td><?= $linha["reservado"] ?></td>
                   <td><?= $linha["valor_diaria"] ?></td>
                    <td>
                        <button type="button">
                            <a href="cadastro.php?numero=<?= $linha["numero"] ?>">Editar</a>
                        </button>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <button type="button"><a href="cadastro.php">Criar novo</a></button>
    </body>
</html>

<?php

$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>