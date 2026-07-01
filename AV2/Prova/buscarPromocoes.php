<?php
header('Content-Type: application/json');

$host = 'localhost';
$bd = 'salao';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $bd);
    $conn->set_charset("utf8mb4");

    $promocoes = [];
    
    $sql = "SELECT titulo, descricao, regra_uso FROM promocoes";
    $resultado = $conn->query($sql);

    while ($linha = $resultado->fetch_assoc()) {
        $promocoes[] = [
            'titulo' => $linha['titulo'],
            'descricao' => $linha['descricao'],
            'regra_uso' => $linha['regra_uso']
        ];
    }

    echo json_encode(["sucesso" => true, "dados" => $promocoes]);

    $conn->close();
} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro: " . $e->getMessage()]);
}
?>