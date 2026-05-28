<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $idPro = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $tipo = $_POST['tipo'] ?? '';

    if (empty($idPro)) {
        echo json_encode(["sucesso" => false, "mensagem" => "ID inválido."]);
        exit;
    }

    $html = "";
    $encontrou = false;

    if ($tipo === 'objetiva' && file_exists("PerguntaM.txt")) {
        $arq = fopen("PerguntaM.txt", "r");
        $cabM = fgetcsv($arq, 0, ";");

        $html .= "<table>";
        if (!empty($cabM)) {
            $html .= "<tr>";
            $html .= "<th>" . htmlspecialchars($cabM[0]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabM[1]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabM[3]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabM[4]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabM[5]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabM[6]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabM[7]) . "</th>";
            $html .= "</tr>";
        }

        while (($dados = fgetcsv($arq, 0, ";")) !== FALSE) {
            if ($dados[0] == $idPro) {
                $html .= "<tr>";
                $html .= "<td>" . htmlspecialchars($dados[0]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[1]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[3]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[4]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[5]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[6]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[7]) . "</td>";
                $html .= "</tr>";
                $encontrou = true;
                break;
            }
        }
        $html .= "</table>";
        fclose($arq);

    } elseif ($tipo === 'discursiva' && file_exists("PerguntaD.txt")) {
        $arq = fopen("PerguntaD.txt", "r");
        $cabD = fgetcsv($arq, 0, ";");

        $html .= "<table>";
        if (!empty($cabD)) {
            $html .= "<tr>";
            $html .= "<th>" . htmlspecialchars($cabD[0]) . "</th>";
            $html .= "<th>" . htmlspecialchars($cabD[1]) . "</th>";
            $html .= "</tr>";
        }

        while (($dados = fgetcsv($arq, 0, ";")) !== FALSE) {
            if ($dados[0] == $idPro) {
                $html .= "<tr>";
                $html .= "<td>" . htmlspecialchars($dados[0]) . "</td>";
                $html .= "<td>" . htmlspecialchars($dados[1]) . "</td>";
                $html .= "</tr>";
                $encontrou = true;
                break;
            }
        }
        $html .= "</table>";
        fclose($arq);
    }

    if ($encontrou) {
        echo json_encode(["sucesso" => true, "html" => $html]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Pergunta não encontrada."]);
    }
    exit;
}
?>