<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    
    // Avisa que a resposta será um JSON
    header('Content-Type: application/json');

    if (!file_exists("alunos.txt")) {
        echo json_encode(["sucesso" => false, "mensagem" => "Nenhum aluno cadastrado ainda."]);
        exit;
    }

    $arquivo = fopen("alunos.txt", "r");
    
    if (!$arquivo) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro ao abrir o arquivo."]);
        exit;
    }

    // Criamos uma variável de texto para ir montando o HTML da tabela
    $tabelaHTML = "<table>";
    
    // Pega a primeira linha (Cabeçalho)
    $cabecalho = fgetcsv($arquivo, 0, ";");
    
    if (!empty($cabecalho)) {
        $tabelaHTML .= "<tr>";
        foreach ($cabecalho as $coluna) {
            $tabelaHTML .= "<th>" . htmlspecialchars($coluna) . "</th>";
        }
        $tabelaHTML .= "</tr>";
    }

    // Pega o restante das linhas (Os alunos)
    while (($dados = fgetcsv($arquivo, 0, ";")) !== FALSE) {
        
        // Verifica se a linha não está vazia para evitar tr fantasmas
        if (!empty($dados) && array_filter($dados)) {
            $tabelaHTML .= "<tr>";
            foreach ($dados as $valor) {
                $tabelaHTML .= "<td>" . htmlspecialchars($valor) . "</td>";
            }
            $tabelaHTML .= "</tr>";
        }
    }
    
    $tabelaHTML .= "</table>";
    fclose($arquivo);

    // Manda a resposta com a tabela montada embutida na propriedade "html"
    echo json_encode([
        "sucesso" => true, 
        "html" => $tabelaHTML
    ]);
    
    exit;
}
?>