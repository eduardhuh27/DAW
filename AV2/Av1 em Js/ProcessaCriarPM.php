<?php
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $pergunta = htmlspecialchars($_POST['pergunta'] ?? "");
    $oA = htmlspecialchars($_POST['a'] ?? "");
    $oB = htmlspecialchars($_POST['b'] ?? "");
    $oC = htmlspecialchars($_POST['c'] ?? "");
    $oD = htmlspecialchars($_POST['d'] ?? "");
    $oE = htmlspecialchars($_POST['e'] ?? "");
    $resposta = htmlspecialchars($_POST['resposta'] ?? "");

    if (empty($id) || empty($pergunta) || empty($oA) || empty($oB) || empty($oC) || empty($oD) || empty($oE) || empty($resposta)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro: Preencha todos os campos do formulário."]);
        exit;
    }

    if (!file_exists("PerguntaM.txt")) {
        $arq = fopen("PerguntaM.txt", "w");
        if (!$arq) {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro interno ao tentar criar o arquivo."]);
            exit;
        }
        $linha = "id;pergunta;resposta;A;B;C;D;E\n";
        fwrite($arq, $linha);
        fclose($arq);
    }

    $arq = fopen("PerguntaM.txt", "a");
    
    if (!$arq) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro ao abrir o arquivo para gravação."]);
        exit;
    }

    $linha = $id . ";" . $pergunta . ";" . $resposta . ";" . $oA . ";" . $oB . ";" . $oC . ";" . $oD . ";" . $oE . "\n";
    fwrite($arq, $linha);
    fclose($arq);

    echo json_encode(["sucesso" => true, "mensagem" => "Pergunta objetiva salva com sucesso!"]);
    exit;

} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso negado."]);
    exit;
}
?>