<?php
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    echo json_encode([
        "sucesso" => false, 
        "erro_login" => true, 
        "mensagem" => "Precisa de iniciar sessão para ver os seus agendamentos."
    ]);
    exit;
}

$host = 'localhost';
$dbname = 'salao';
$username = 'root';
$password = '';

try {
    $conn = new mysqli($host, $username, $password, $dbname);
    $conn->set_charset("utf8mb4");

    $html = "";

    $id_usuario = $_SESSION['id_usuario'];
    $situcaoEscolhida="Esperando pagamento";

    $comandoBusca = $conn->prepare("SELECT id, valor, dia, horario, servico, profissional FROM agendamento WHERE id_usuario = ? and situacao=?");
    $comandoBusca->bind_param("is", $id_usuario,$situcaoEscolhida);
    $comandoBusca->execute();
    $resultM = $comandoBusca->get_result();


    $meses = [
        '01' => 'Janeiro', '02' => 'Fevereiro', '03' => 'Março',
        '04' => 'Abril', '05' => 'Maio', '06' => 'Junho',
        '07' => 'Julho', '08' => 'Agosto', '09' => 'Setembro',
        '10' => 'Outubro', '11' => 'Novembro', '12' => 'Dezembro'
    ];

    while ($linha = $resultM->fetch_assoc()) {
        $servico = htmlspecialchars($linha['servico'] ?? 'Agendamento');
        $horario = htmlspecialchars($linha['horario']);
        

        $timestamp = strtotime($linha['dia']);
        $diaFormatado = date('d', $timestamp);
        $mesFormatado = $meses[date('m', $timestamp)] ?? date('m', $timestamp);

        if ($linha['profissional'] != 'Qualquer') {
            $profissional = htmlspecialchars($linha['profissional']);
        } else {
            $profissional = 'Nossa melhor equipe';
        }
        
        $html .= '<div class="appointment-card">';
        $html .= '    <h3 class="card-title">' . $servico . '</h3>';
        $html .= '    <div class="card-content">';
        $html .= '        <div class="info-left">';
        $html .= '            <p><span class="label">DIA:</span> ' . $diaFormatado . '</p>';
        $html .= '            <p><span class="label">Mês:</span> ' . $mesFormatado . '</p>';
        $html .= '            <p><span class="label">Com:</span> ' . $profissional . '</p>';
        $html .= '        </div>';
        $html .= '        <div class="info-right">';
        $html .= '            <p><span class="label">Hora:</span></p>';
        $html .= '            <p class="time-value">' . $horario . '</p>';
        $html .= '        </div>';
        $html .= '  <button class="btn-resgatar" onclick="irParaPagamento(' . $linha['id'] . ', ' . $linha['valor'] . ')">Pagar Agora</button>';
        $html .= '    </div>';
        $html .= '</div>';
    }

    if ($resultM->num_rows === 0) {
        $html = "<p style='text-align:center; grid-column: 1 / -1; font-weight:bold;'>Você ainda não possui agendamentos marcados.</p>";
    }

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