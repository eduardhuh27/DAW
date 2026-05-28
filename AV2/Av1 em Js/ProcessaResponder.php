<?php
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    $tipo = $_POST['tipo'];
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $resposta_usuario = htmlspecialchars($_POST['resposta'] ?? "");

    $arquivoNome = ($tipo == 'D') ? "PerguntaD.txt" : "PerguntaM.txt";

    if (!file_exists($arquivoNome)) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Ficheiro não encontrado.']);
        exit;
    }

    $arq = fopen($arquivoNome, "r");
    $encontrado = false;
    $linhaDados = [];

    while (($dados = fgetcsv($arq, 0, ";")) !== FALSE) {
        if ($dados[0] == $id) {
            $encontrado = true;
            $linhaDados = $dados;
            break;
        }
    }
    fclose($arq);

    if (!$encontrado) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Pergunta não encontrada.']);
        exit;
    }

    if ($acao == 'buscar') {
        if ($tipo == 'D') {
            echo json_encode([
                'sucesso' => true,
                'dados' => [
                    'id' => $linhaDados[0],
                    'pergunta' => $linhaDados[1]
                ]
            ]);
        } else {
            echo json_encode([
                'sucesso' => true,
                'dados' => [
                    'id' => $linhaDados[0],
                    'pergunta' => $linhaDados[1],
                    'a' => $linhaDados[3] ?? '',
                    'b' => $linhaDados[4] ?? '',
                    'c' => $linhaDados[5] ?? '',
                    'd' => $linhaDados[6] ?? '',
                    'e' => $linhaDados[7] ?? ''
                ]
            ]);
        }
        exit;
    }

    if ($acao == 'responder') {
        $resposta_correta = $linhaDados[2];

        if ($tipo == 'D') {
            if ($resposta_usuario == $resposta_correta) {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Sua resposta está correta: ' . $resposta_usuario]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Sua resposta está incorreta: ' . $resposta_usuario]);
            }
        } else {
            $letra = strtolower(trim($resposta_usuario));
            $resposta_escolhida = "";

            switch ($letra) {
                case 'a': $resposta_escolhida = $linhaDados[3] ?? ''; break;
                case 'b': $resposta_escolhida = $linhaDados[4] ?? ''; break;
                case 'c': $resposta_escolhida = $linhaDados[5] ?? ''; break;
                case 'd': $resposta_escolhida = $linhaDados[6] ?? ''; break;
                case 'e': $resposta_escolhida = $linhaDados[7] ?? ''; break;
            }

            if ($resposta_escolhida == $resposta_correta && $resposta_escolhida !== "") {
                echo json_encode(['sucesso' => true, 'mensagem' => 'Sua resposta está correta: ' . $resposta_escolhida]);
            } else {
                echo json_encode(['sucesso' => false, 'mensagem' => 'Sua resposta está incorreta: ' . ($resposta_escolhida ?: $resposta_usuario)]);
            }
        }
        exit;
    }
}
?>