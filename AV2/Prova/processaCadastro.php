<?php 
session_start();
    header('Content-Type: application/json');


    $host='localhost';
    $bd='salao';
    $username='root';
    $password='';

    $conn= new mysqli($host,$username,$password,$bd);


    if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nome = htmlspecialchars($_POST['nome'] ?? "");
        $email = htmlspecialchars($_POST['email'] ?? "");
        $senha = htmlspecialchars($_POST['senha'] ?? "");
        
        if (empty($nome) || empty($email) || empty($senha)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
            exit;
        }
            $comandoInsert = $conn->prepare("INSERT INTO usuario (nome, email, senha) VALUES (?, ?, ?)");
            $comandoInsert->bind_param("sss", $nome, $email, $senha);
            
            if ($comandoInsert->execute()) {
                $_SESSION['logado'] = false;
                $_SESSION['nome'] = $nome;
                echo json_encode(["sucesso" => true, "mensagem" => "Cadastro realizado com sucesso! Bem-vindo, " . $nome . "."]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Erro ao criar novo utilizador."]);
            }
            $comandoInsert->close();
        
        
        $conn->close();
        exit;

    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
        exit;
    }

?>