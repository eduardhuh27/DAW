<?php
session_start();

header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'daw';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

    $html = "";

    $html .= "<table>";
    $html .= "<tr>";
    $html .= "<th>ID</th>";
    $html .= "<th>Pergunta</th>";
    $html .= "<th>Resposta Correta</th>";
    $html .= "<th>A</th>";
    $html .= "<th>B</th>";
    $html .= "<th>C</th>";
    $html .= "<th>D</th>";
    $html .= "<th>E</th>";
    $html .= "</tr>";

    $sqlM = "SELECT id, pergunta, resposta_padrao, a, b, c, d, e FROM pergunta_objetiva";
    $resultM = $conn->query($sqlM);

    while ($linha = $resultM->fetch_assoc()) {
        $html .= "<tr>";
        $html .= "<td>" . htmlspecialchars($linha['id']) . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['pergunta']) . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['resposta'] ?? '') . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['a'] ?? '') . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['b'] ?? '') . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['c'] ?? '') . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['d'] ?? '') . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['e'] ?? '') . "</td>";
        $html .= "</tr>";
    }
    $html .= "</table><br><br>";

    $html .= "<table>";
    $html .= "<tr>";
    $html .= "<th>ID</th>";
    $html .= "<th>Pergunta</th>";
    $html .= "<th>Resposta Padrão</th>";
    $html .= "</tr>";

    $sqlD = "SELECT id, pergunta, resposta_padrao FROM pergunta_discursiva";
    $resultD = $conn->query($sqlD);

    while ($linha = $resultD->fetch_assoc()) {
        $html .= "<tr>";
        $html .= "<td>" . htmlspecialchars($linha['id']) . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['pergunta']) . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['resposta_padrao']) . "</td>";
        $html .= "</tr>";
    }
    $html .= "</table>";

    echo json_encode(["sucesso" => true, "html" => $html]);

    $conn->close();
    exit;

} catch (Exception $e) {
    echo json_encode([
        "sucesso" => false, 
        "mensagem" => "ERRO NO BANCO DE DADOS: " . $e->getMessage()
    ]);
    exit;
}
?>