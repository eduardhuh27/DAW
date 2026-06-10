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
        
        $idPro = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $tipo = $_POST['tipo'] ?? '';

        if (empty($idPro)) {
            echo json_encode(["sucesso" => false, "mensagem" => "ID inválido."]);
            exit;
        }

        $html = "";
        $encontrou = false;

        if ($tipo === 'objetiva') {
            
           
            $comandoSQL = $conn->prepare("SELECT id, pergunta,resposta_padrao, a, b, c, d, e FROM pergunta_objetiva WHERE id = ?");
            $comandoSQL->bind_param("i", $idPro);
            $comandoSQL->execute();
            
            $resultado = $comandoSQL->get_result();

            if ($linha = $resultado->fetch_assoc()) {
                $html .= "<table>";
                

                $html .= "<tr>";
                $html .= "<th>ID</th>";
                $html .= "<th>Pergunta</th>";
                $html .= "<th>Resposta</th>";
                $html .= "<th>A</th>";
                $html .= "<th>B</th>";
                $html .= "<th>C</th>";
                $html .= "<th>D</th>";
                $html .= "<th>E</th>";
                $html .= "</tr>";

                $html .= "<tr>";
                $html .= "<td>" . htmlspecialchars($linha['id']) . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['pergunta']) . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['resposta_padrao']) . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['a'] ?? '') . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['b'] ?? '') . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['c'] ?? '') . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['d'] ?? '') . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['e'] ?? '') . "</td>";
                $html .= "</tr>";
                
                $html .= "</table>";
                $encontrou = true;
            }
            $comandoSQL->close();

        } elseif ($tipo === 'discursiva') {
            
            $comandoSQL = $conn->prepare("SELECT id, pergunta,resposta_padrao FROM pergunta_discursiva WHERE id = ?");
            $comandoSQL->bind_param("i", $idPro);
            $comandoSQL->execute();
            
            $resultado = $comandoSQL->get_result();

            if ($linha = $resultado->fetch_assoc()) {
                $html .= "<table>";
               
                $html .= "<tr>";
                $html .= "<th>ID</th>";
                $html .= "<th>Pergunta</th>";
                $html .= "<th>Resposta</th>";
                $html .= "</tr>";

               
                $html .= "<tr>";
                $html .= "<td>" . htmlspecialchars($linha['id']) . "</td>";
                $html .= "<td>" . htmlspecialchars($linha['pergunta']) . "</td>";
                 $html .= "<td>" . htmlspecialchars($linha['resposta_padrao']) . "</td>";
                $html .= "</tr>";
                
                $html .= "</table>";
                $encontrou = true;
            }
            $comandoSQL->close();
        }

        if ($encontrou) {
            echo json_encode(["sucesso" => true, "html" => $html]);
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Pergunta não encontrada no banco de dados."]);
        }
        
        $conn->close();
        exit;
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Método de acesso inválido."]);
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