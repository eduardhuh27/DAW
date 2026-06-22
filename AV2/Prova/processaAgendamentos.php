<?php
session_start();

header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'salao';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

    $html = "";

    $html .= "<table>";
    $html .= "<tr>";
    $html .= "<th>Dia</th>";
    $html .= "<th>Horario</th>";
    $html .= "<th>Servico</th>";
    $html .= "<th>Profissional</th>";
    $html .= "</tr>";

    $sqlM = "SELECT dia, horario,servico, profissional FROM agendamento";
    $resultM = $conn->query($sqlM);

    while ($linha = $resultM->fetch_assoc()) {
        $html .= "<tr>";
        $html .= "<td>" . htmlspecialchars($linha['dia']) . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['horario']) . "</td>";
        $html .= "<td>" . htmlspecialchars($linha['servico'] ?? '') . "</td>";
        if($linha['profissional']!='Qualquer')
        $html .= "<td>" . htmlspecialchars($linha['profissional'] ?? '') . "</td>";
        else{
            $html .= "<td>" . htmlspecialchars('Escolhendo o melhor para lhe atender') . "</td>";
        }
        
        $html .= "</tr>";
    }
    $html .= "</table><br><br>";


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