<?php
try {
    include "abrir_transacao.php";
include_once "operacoes.php";

$tipos = listar_todos_tipos();

function validar($quarto) {
    global $tipos;
    return strlen($quarto["camas_solteiro"]) >= 4
        && strlen($quarto["camas_solteiro"]) <= 30
        && strlen($quarto["camas_casal"]) >= 4
        && strlen($quarto["camas_casal"]) <= 50
        && strlen($quarto["area_m2"]) >= 4
        && strlen($quarto["area_m2"]) <= 200
        && $quarto["reservado"] >= 0
        && $quarto["reservado"] <= 5000000
        && $quarto["valor_diaria"] >= 0
        && $quarto["valor_diaria"] <= 5000000
        
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
        <title>Cadastro de folhas</title>
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
                    <label for="numero">Chave:</label>
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
                <label for="local">Local:</label>
                <input type="text" id="localizacao" name="localizacao" value="<?= $flor["localizacao"] ?>">
            </div>
            <div>
                <label for="folhas">Folhas:</label>
                <input type="text" id="folhas" name="folhas" value="<?= $flor["folhas"] ?>">
            </div>
            <div>
                <label for="tipo">Tipo de flor:</label>
                <select id="tipo" name="tipo">
                    <option>Escolha...</option>
                    <?php foreach ($tipos as $tipo) { ?>
                        <option value="<?= $tipo ?>"
                            <?php if ($flor["tipo"] === $tipo) { ?>
                            selected
                            <?php } ?>
                        >
                            <?= $tipo ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div>
                <button type="button" onclick="confirmar()">Salvar</button>
            </div>
        </form>
        <?php if ($alterar) { ?>
            <form action="excluir.php"
                    method="POST"
                    style="display: none"
                    id="excluir-flor">
                <input type="hidden" name="chave" value="<?= $flor["chave"] ?>" >
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