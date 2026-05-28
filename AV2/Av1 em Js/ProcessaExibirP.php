<?php
session_start();

header('Content-Type: application/json');

$html = "";

if (file_exists('PerguntaM.txt') && file_exists('PerguntaD.txt')) {
    $arqM = fopen("PerguntaM.txt", 'r');
    $arqD = fopen("PerguntaD.txt", 'r');

    if ($arqM && $arqD) {
        $cabM = fgetcsv($arqM, 0, ";");
        $cabD = fgetcsv($arqD, 0, ";");

        $html .= "<table>";
        if (!empty($cabM)) {
            $html .= "<tr>";
            foreach ($cabM as $coluna) {
                $html .= "<th>" . htmlspecialchars($coluna) . "</th>";
            }
            $html .= "</tr>";
        }
        while (($dados = fgetcsv($arqM, 0, ";")) !== FALSE) {
            if (!empty($dados) && array_filter($dados)) {
                $html .= "<tr>";
                foreach ($dados as $valor) {
                    $html .= "<td>" . htmlspecialchars($valor) . "</td>";
                }
                $html .= "</tr>";
            }
        }
        $html .= "</table><br><br>";

        $html .= "<table>";
        if (!empty($cabD)) {
            $html .= "<tr>";
            foreach ($cabD as $coluna) {
                $html .= "<th>" . htmlspecialchars($coluna) . "</th>";
            }
            $html .= "</tr>";
        }
        while (($dados = fgetcsv($arqD, 0, ";")) !== FALSE) {
            if (!empty($dados) && array_filter($dados)) {
                $html .= "<tr>";
                foreach ($dados as $valor) {
                    $html .= "<td>" . htmlspecialchars($valor) . "</td>";
                }
                $html .= "</tr>";
            }
        }
        $html .= "</table>";

        fclose($arqM);
        fclose($arqD);

        echo json_encode(["sucesso" => true, "html" => $html]);
        exit;
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro ao abrir os arquivos de leitura."]);
        exit;
    }
} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Arquivos de perguntas não encontrados."]);
    exit;
}
?>