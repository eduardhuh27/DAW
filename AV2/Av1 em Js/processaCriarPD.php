<?php
session_start();

 
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $pergunta = htmlspecialchars($_POST['pergunta'] ?? "");
    $resposta = htmlspecialchars($_POST['resposta'] ?? "");

   
    if (empty($id) || empty($pergunta) || empty($resposta)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro: Preencha todos os campos do formulário."]);
        exit;
    }

   
    if (!file_exists("PerguntaD.txt")) {
        $arq = fopen("PerguntaD.txt", "w");
        if (!$arq) {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro interno ao tentar criar o arquivo."]);
            exit;
        }
        $linha = "id;pergunta;resposta\n";
        fwrite($arq, $linha);
        fclose($arq);
    }

    
    $arq = fopen("PerguntaD.txt", "a");
    
    if (!$arq) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro ao abrir o arquivo para gravação."]);
        exit;
    }

    $linha = $id . ";" . $pergunta . ";" . $resposta . "\n";
    fwrite($arq, $linha);
    fclose($arq);

    echo json_encode(["sucesso" => true, "mensagem" => "Pergunta discursiva salva com sucesso!"]);
    exit;

} else {
   
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso negado. Use o formulário."]);
    exit;
}
?>