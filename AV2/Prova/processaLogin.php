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
        
        if ( empty($email) || empty($senha)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
            exit;
        }

        $comandoBusca = $conn->prepare("SELECT senha,nome FROM usuario WHERE email = ?");
        $comandoBusca->bind_param("s", $email);
        $comandoBusca->execute();
        $resultado = $comandoBusca->get_result();

        if ($linha = $resultado->fetch_assoc()) {
            if ($linha['senha'] === $senha) {
                $_SESSION['logado'] = true;
                $_SESSION['nome'] = $linha['nome'];
                $nome = $linha['nome'];
                echo json_encode(["sucesso" => true, "mensagem" => "Login realizado com sucesso! Bem-vindo, " . $nome . "."]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Usuário já existe, mas a senha está incorreta!"]);
            }
        }
        $comandoBusca->close();
        $conn->close();
        exit;

    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
        exit;
    }

?>