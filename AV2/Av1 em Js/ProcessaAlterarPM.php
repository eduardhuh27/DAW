<?php 
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['acao'])) {
    header('Content-Type: application/json');
    
    $acao = $_POST['acao'];
    $resposta_json = ['sucesso' => false, 'mensagem' => ''];

    if(!file_exists("PerguntaM.txt")) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Ficheiro PerguntaM.txt não encontrado']);
        exit;
    }

    if($acao == 'buscar') {
        $idPro = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $arq = fopen("PerguntaM.txt", "r");
        $encontrado = false;
        
        while(($dados = fgetcsv($arq, 0, ";")) !== FALSE) {
            if($dados[0] == $idPro) {
                $resposta_json = [
                    'sucesso' => true,
                    'dados' => [
                        'id' => $dados[0],
                        'pergunta' => $dados[1],
                        'resposta' => $dados[2],
                        'a' => $dados[3] ?? '',
                        'b' => $dados[4] ?? '',
                        'c' => $dados[5] ?? '',
                        'd' => $dados[6] ?? '',
                        'e' => $dados[7] ?? ''
                    ]
                ];
                $encontrado = true;
                break;
            }
        }
        fclose($arq);
        
        if(!$encontrado) {
            $resposta_json['mensagem'] = "Pergunta não encontrada.";
        }
        echo json_encode($resposta_json);
        exit;
    }

    if($acao == 'atualizar') {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $pergunta = htmlspecialchars($_POST['pergunta'] ?? "");
        $resposta = htmlspecialchars($_POST['resposta'] ?? "");
        $a = htmlspecialchars($_POST['a'] ?? "");
        $b = htmlspecialchars($_POST['b'] ?? "");
        $c = htmlspecialchars($_POST['c'] ?? "");
        $d = htmlspecialchars($_POST['d'] ?? "");
        $e = htmlspecialchars($_POST['e'] ?? "");
        
        $arq = fopen("PerguntaM.txt", "r");
        $arqt = fopen("temp.txt", "w");
        $atualizado = false;

        while(($dados = fgetcsv($arq, 0, ";")) !== FALSE) {
            if($dados[0] == $id) {
                $linha = $id.";".$pergunta.";".$resposta.";".$a.";".$b.";".$c.";".$d.";".$e."\n";
                fwrite($arqt, $linha);
                $atualizado = true;
            } else {
                fwrite($arqt, implode(";", $dados)."\n");
            }
        }
        fclose($arq);
        fclose($arqt);
        
        if($atualizado) {
            rename("temp.txt", "PerguntaM.txt");
            $resposta_json = ['sucesso' => true, 'mensagem' => 'Pergunta atualizada com sucesso!'];
        } else {
            unlink("temp.txt");
            $resposta_json['mensagem'] = "Erro ao atualizar.";
        }
        echo json_encode($resposta_json);
        exit;
    }

    if($acao == 'deletar') {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $arq = fopen("PerguntaM.txt", "r");
        $arqt = fopen("temp.txt", "w");
        $deletado = false;

        while(($dados = fgetcsv($arq, 0, ";")) !== FALSE) {
            if($dados[0] == $id) {
                $deletado = true;
            } else {
                fwrite($arqt, implode(";", $dados)."\n");
            }
        }
        fclose($arq);
        fclose($arqt);
        
        if($deletado) {
            rename("temp.txt", "PerguntaM.txt");
            $resposta_json = ['sucesso' => true, 'mensagem' => 'Pergunta apagada com sucesso!'];
        } else {
            unlink("temp.txt");
            $resposta_json['mensagem'] = "Erro ao apagar.";
        }
        echo json_encode($resposta_json);
        exit;
    }
}
?>