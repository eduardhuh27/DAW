<?php 
    session_start();
    header('Content-Type: application/json');


    $host = 'localhost';
    $bd = 'salao';
    $username = 'root';
    $password = '';

    try {
        $conn = new mysqli($host, $username, $password, $bd);
        $conn->set_charset("utf8mb4");

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $id_pedido = filter_input(INPUT_POST, 'id_pedido', FILTER_SANITIZE_NUMBER_INT);
            $metodo_pagamento = htmlspecialchars($_POST['metodo_pagamento'] ?? "");
            $acao = htmlspecialchars($_POST['acao'] ?? "");

            if (empty($id_pedido) || empty($metodo_pagamento)) {
                echo json_encode(["sucesso" => false, "mensagem" => "Dados de pagamento incompletos."]);
                exit;
            }

            if ($acao === 'atualizar_situacao') {
            
                $conn->begin_transaction();

                $comandoUpdate = $conn->prepare("UPDATE agendamento SET situacao = 'Pago' WHERE id = ?");
                $comandoUpdate->bind_param("i", $id_pedido);
                $comandoUpdate->execute();
                
               
                if ($comandoUpdate->affected_rows === 0) {
                    $conn->rollback(); 
                    echo json_encode(["sucesso" => false, "mensagem" => "Nenhum agendamento encontrado com este ID."]);
                    $comandoUpdate->close();
                    exit;
                }
                $comandoUpdate->close();

                
                $comandoInsert = $conn->prepare("INSERT INTO pagamento (id_pedido, metodo_pagamento) VALUES (?, ?)");
                $comandoInsert->bind_param("is", $id_pedido, $metodo_pagamento);
                
                if ($comandoInsert->execute()) {

                    $conn->commit(); 
                    echo json_encode(["sucesso" => true, "mensagem" => "Pagamento aprovado e registrado com sucesso!"]);
                } else {
                    $conn->rollback();
                    echo json_encode(["sucesso" => false, "mensagem" => "Erro ao registrar os detalhes do pagamento."]);
                }
                
                $comandoInsert->close();
                $conn->close();
                exit;

            } else {
                echo json_encode(["sucesso" => false, "mensagem" => "Ação de pagamento não reconhecida."]);
                exit;
            }

        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Método inválido. Use POST."]);
            exit;
        }

    } catch (Exception $e) {
      
        if (isset($conn) ) {
            $conn->rollback();
        }
        echo json_encode([
            "sucesso" => false, 
            "mensagem" => "Erro no banco de dados: " . $e->getMessage()
        ]);
        exit;
    }
?>