<?php
header('Content-Type: application/json');

$host = 'localhost';
$bd = 'salao';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $bd);
    $conn->set_charset("utf8mb4");

    $profissionais = [];
    
    $sql = "SELECT nome, especialidade FROM profissionais";
    $resultado = $conn->query($sql);

    while ($linha = $resultado->fetch_assoc()) {
        $profissionais[] = [
            'nome' => $linha['nome'],
            'especialidade' => $linha['especialidade']
        ];
    }

    echo json_encode(["sucesso" => true, "dados" => $profissionais]);

    $conn->close();
} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro: " . $e->getMessage()]);
}
?>