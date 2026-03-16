<?php session_start()?>
<?php
   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = htmlspecialchars($_POST["nome"] ?? "");
    $matriculaNova = filter_input(INPUT_POST, "matricula", FILTER_SANITIZE_NUMBER_INT);
    $email = htmlspecialchars($_POST["email"] ?? "");
    
  
    $matriculaParaProcurar = $_SESSION['procura'] ?? "";

    if (!empty($matriculaParaProcurar)) {
        $linhasAtualizadas = [];
        $encontrou = false;
        $caminho = "alunos.txt";

        if (file_exists($caminho)) {
            $arquivo = fopen($caminho, "r");
            
          
            while (($dados = fgetcsv($arquivo, 0, ";")) !== FALSE) {
                
                if ($dados[1] == $matriculaParaProcurar) {
                    $linhasAtualizadas[] = "$nome;$matriculaNova;$email";
                    $encontrou = true;
                } else {
                    $linhasAtualizadas[] = implode(";", $dados);
                }
            }
            fclose($arquivo);

          
            if ($encontrou) {
                $arquivoEscrita = fopen($caminho, "w");
                fwrite($arquivoEscrita, implode("\n", $linhasAtualizadas) . "\n");
                fclose($arquivoEscrita);
                $_SESSION['mensagem_resultado'] = "Aluno alterado com sucesso!";
            } else {
                $_SESSION['mensagem_erro'] = "Aluno não encontrado para alteração.";
            }
        }
    }
    }

    exit;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Alterar aluno</h1>
<form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Nome: <input type="text" name="nome">
    <br><br>
    Matricula: <input type="text" name="matricula">
    <br><br>
    Email: <input type="text" name="email">
    <br><br>
    <input type="submit" value="Alterar Aluno">
</form>
</body>
</html>