<?php
session_start();


header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $nome = htmlspecialchars($_POST['nome'] ?? "");
    $email = htmlspecialchars($_POST['email'] ?? "");
    $senha = htmlspecialchars($_POST['senha'] ?? "");
    
    if (empty($nome) || empty($email) || empty($senha)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
        exit;
    }

    if (!file_exists("cadastro.txt")) {
        $arq = fopen("cadastro.txt", "w");
        fwrite($arq, "nome;email;senha\n");
        fclose($arq);
    }

    $logado = false;
    
    $arqV = fopen("cadastro.txt", "r");
    fgetcsv($arqV, 0, ";");

    while (($login = fgetcsv($arqV, 0, ";")) !== FALSE) {
        if ($login[0] == $nome) {
          
            if ($login[2] == $senha) {
                $logado = true; 
                break;
            } else {
                
                fclose($arqV);
                echo json_encode(["sucesso" => false, "mensagem" => "Usuário já existe, mas a senha está incorreta!"]);
                exit;
            }
        }
    }
    fclose($arqV);

    
    if (!$logado) {
        $arq = fopen("cadastro.txt", "a");
        $linha = $nome . ";" . $email . ";" . $senha . "\n";
        fwrite($arq, $linha);
        fclose($arq);
        $logado = true; 
    }

    if ($logado) {
    
        echo json_encode(["sucesso" => true, "mensagem" => "Login realizado com sucesso! Bem-vindo, " . $nome . "."]);
        exit;
    }
} else {
    echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
}
?>