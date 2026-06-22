<?php 
    session_start();
    header('Content-Type: application/json');


    $host='localhost';
    $bd='salao';
    $username='root';
    $password='';

    $conn= new mysqli($host,$username,$password,$bd);


    if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $valor= htmlspecialchars($_POST['valor'] ?? "");
    $servico = htmlspecialchars($_POST['servico'] ?? "");
    $profissional = htmlspecialchars($_POST['profissional'] ?? "");
    $data = htmlspecialchars($_POST['data'] ?? "");
    $horario = htmlspecialchars($_POST['horario'] ?? "");    

        if (empty($servico) || empty($profissional) || empty($data) || empty($horario)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos."]);
            exit;
        }
            $comandoInsert = $conn->prepare("INSERT INTO agendamento (servico,profissional, dia ,horario,valor,situacao ) VALUES (?, ?, ?,?,?,'Esperando pagamento')");
            $comandoInsert->bind_param("ssssi", $servico, $profissional, $data,$horario,$valor);
            
            if ($comandoInsert->execute()) {
                $nome= $_SESSION['nome'] ;
                echo json_encode(["sucesso" => true, "mensagem" => "Agendamento realizado com sucesso!"]);
            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Erro ao criar novo agendamento."]);
            }
            $comandoInsert->close();
        
        
        $conn->close();
        exit;

    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
        exit;
    }

?>