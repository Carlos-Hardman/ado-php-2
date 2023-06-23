<?php
try {
    include "abrir_transacao.php";
    include_once "operacoes.php";

function validar($quarto) {
    
    return strlen($quarto["camas_solteiro"]) >= 0
        && strlen($quarto["camas_solteiro"]) >= 0
        && strlen($quarto["camas_casal"]) >= 0
        && strlen($quarto["camas_casal"]) >=0
        && strlen($quarto["area_m2"]) >= 0
        && strlen($quarto["area_m2"]) >=0
        && $quarto["reservado"] >= 0
        && $quarto["reservado"] <=1
       && $quarto["valor_diaria"] >=0
        && $quarto["valor_diaria"] >=0;
        
        
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {

    $alterar = isset($_GET["numero"]);
    if ($alterar) {
        $numero = $_GET["numero"];
        $quarto = buscar_quarto($numero);
        if ($quarto == null) die("Não existe!");
    } else {
        $numero = "";
        $quarto = [
            "camas_solteiro" => "",
            "camas_casal" => "",
            "area_m2" => "",
            "reservado" => "",
            "valor_diaria" => "",
            
        ];
    }
    $validacaoOk = true;

} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $alterar = isset($_POST["numero"]);

    if ($alterar) {
        $quarto = [
            "numero" => $_POST["numero"],
            "camas_solteiro" => $_POST["camas_solteiro"],
            "camas_casal" => $_POST["camas_casal"],
            "area_m2" => $_POST["area_m2"],
            "reservado" => $_POST["reservado"],
            "valor_diaria" => $_POST["valor_diaria"],
            
        ];
        $validacaoOk = validar($quarto);
        if ($validacaoOk) alterar_quarto($quarto);
    } else {
        $quarto = [
            "camas_solteiro" => $_POST["camas_solteiro"],
            "camas_casal" => $_POST["camas_casal"],
            "area_m2" => $_POST["area_m2"],
            "reservado" => $_POST["reservado"],
            "valor_diaria" => $_POST["valor_diaria"],
        ];
        $validacaoOk = validar($quarto);
        if ($validacaoOk) $id = inserir_quarto($quarto);
    }

    if ($validacaoOk) {
        header("Location: listagem.php");
        $transacaoOk = true;
    }
} else {
    die("Método não aceito");
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cadastro de Quartos</title>
        <script>
            function confirmar() {
                if (!confirm("Tem certeza que deseja salvar os dados?")) return;
                document.getElementById("formulario").submit();
            }

            function excluir() {
                if (!confirm("Tem certeza que deseja excluir o quarto?")) return;
                document.getElementById("excluir-quarto").submit();
            }
        </script>
    </head>
    <body>
        <form method="POST" action="cadastro.php" id="formulario">
            <?php if (!$validacaoOk) {?>
                <div>
                    <p>Preencha os campos corretamente!</p>
                </div>
            <?php } ?>
            <?php if ($alterar) { ?>
                <div>
                    <label for="numero">Numero:</label>
                    <input type="text" id="numero" name="numero" value="<?= $quarto["numero"] ?>" readonly>
                </div>
            <?php } ?>
            <div>
                <label for="camas_solteiro">Camas Solteiro:</label>
                <input type="text" id="camas_solteiro" name="camas_solteiro" value="<?= $quarto["camas_solteiro"] ?>">
            </div>
            <div>
                <label for="camas_casal">Camas Casal:</label>
                <input type="text" id="camas_casal" name="camas_casal" value="<?= $quarto["camas_casal"] ?>">
            </div>
            <div>
                <label for="local">area m2:</label>
                <input type="text" id="area_m2" name="area_m2" value="<?= $quarto["area_m2"] ?>">
            </div>
            <div>
                <label for="folhas">reservado:</label>
                <input type="text" id="reservado" name="reservado" value="<?= $quarto["reservado"] ?>">
            </div>
            <div>
                <label for="folhas">valor diaria:</label>
                <input type="text" id="valor_diaria" name="valor_diaria" value="<?= $quarto["valor_diaria"] ?>">
            </div>

            <div>
                <button type="button" onclick="confirmar()">Salvar</button>
            </div>
        </form>
        <?php if ($alterar) { ?>
            <form action="excluir.php"
                    method="POST"
                    style="display: none"
                    id="excluir-quarto">
                <input type="hidden" name="numero" value="<?= $quarto["numero"] ?>" >
            </form>
            <button type="button" onclick="excluir()">Excluir</button>
        <?php } ?>
    </body>
</html>

<?php
$transacaoOk = true;

} finally {
    include "fechar_transacao.php";
}
?>