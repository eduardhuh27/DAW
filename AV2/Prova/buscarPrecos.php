<?php
header('Content-Type: application/json');

$host = 'localhost';
$bd = 'salao';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $bd);
    $conn->set_charset("utf8mb4");

    $precos = [];
    
    $sql = "SELECT nome_servico, preco FROM servico";
    $resultado = $conn->query($sql);

    while ($linha = $resultado->fetch_assoc()) {

        $precos[$linha['nome_servico']] = (float)$linha['preco'];
    }

    echo json_encode(["sucesso" => true, "dados" => $precos]);

    $conn->close();
} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro: " . $e->getMessage()]);
}
?>