<?php
session_start();

header('Content-Type: application/json');
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$dbname = 'daw';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        
        $nome = htmlspecialchars($_POST['nome'] ?? "");
        $email = htmlspecialchars($_POST['email'] ?? "");
        $senha = htmlspecialchars($_POST['senha'] ?? "");
        
        if (empty($nome) || empty($email) || empty($senha)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
            exit;
        }

        $comandoBusca = $conn->prepare("SELECT senha FROM usuario WHERE nome = ?");
        $comandoBusca->bind_param("s", $nome);
        $comandoBusca->execute();
        $resultado = $comandoBusca->get_result();

        if ($linha = $resultado->fetch_assoc()) {
            if ($linha['senha'] === $senha) {
                $_SESSION['logado'] = true;
                $_SESSION['nome'] = $nome;
                echo json_encode(["sucesso" => true, "mensagem" => "Login realizado com sucesso! Bem-vindo, " . $nome . "."]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Usuário já existe, mas a senha está incorreta!"]);
            }
        } else {
            $comandoInsert = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
            $comandoInsert->bind_param("sss", $nome, $email, $senha);
            
            if ($comandoInsert->execute()) {
                $_SESSION['logado'] = true;
                $_SESSION['nome'] = $nome;
                echo json_encode(["sucesso" => true, "mensagem" => "Cadastro e login realizados com sucesso! Bem-vindo, " . $nome . "."]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Erro ao criar novo utilizador."]);
            }
            $comandoInsert->close();
        }
        
        $comandoBusca->close();
        $conn->close();
        exit;

    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
        exit;
    }

} catch (Exception $e) {
    echo json_encode([
        "sucesso" => false, 
        "mensagem" => "ERRO NO BANCO DE DADOS: " . $e->getMessage()
    ]);
    exit;
}
?>