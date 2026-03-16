<?php session_start(); ?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
       
    
        $nome = htmlspecialchars($_POST["nome"] ?? "");
        $email = htmlspecialchars($_POST["email"] ?? "");
        
       
        $matricula = $_SESSION['procura'] ?? "";

        if (!empty($matricula))
        {
            $linha="";
            $encontrou = false;
            $caminho = "alunos.txt";

            if (file_exists($caminho))
            {
                $arquivo = fopen($caminho, "r");
            
               
                while (($dados = fgetcsv($arquivo, 0, ";")) !== FALSE)
                {
                    
                   
                    if (isset($dados[1]) && $dados[1] == $matricula)
                    {
                       
                        $linha .= $nome.";".$matricula .";".$email ."\n" ;
                        $encontrou = true;
                    } else 
                    {
                        
                        if (!empty($dados) && array_filter($dados)) 
                        {
                            $linha .= implode(";", $dados)."\n";
                        }
                    }
                }
                fclose($arquivo);

               
                if ($encontrou)
                {
                    $arquivo = fopen($caminho, "w"); 
                    fwrite($arquivo,$linha);
                    fclose($arquivo);
                    
                    $_SESSION['mensagem_resultado'] = "Aluno alterado com sucesso!"; 
                } 
                else 
                {
                    $_SESSION['mensagem_erro'] = "Aluno não encontrado para alteração.";
                }
            }
        }
        else
        {
            $_SESSION['mensagem_erro'] = "Nenhum aluno selecionado para alteração. Faça a busca primeiro.";
        }
    }
    
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Aluno</title>
    <link rel="stylesheet" href="stylea.css">
</head>
<body>
    <h1>Alterar aluno</h1>
    
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Nome: <input type="text" name="nome" required>
        <br><br>

        Email: <input type="text" name="email" required>
        <br><br>
        <input type="submit" value="Salvar Alterações">
    </form>

    <br>

    <div>
        <?php 
            if(isset($_SESSION['mensagem_resultado']))
            {
                echo $_SESSION['mensagem_resultado'] ;
                unset($_SESSION['mensagem_resultado']);
            }
            if(isset($_SESSION['mensagem_erro'])) 
            {
                echo  $_SESSION['mensagem_erro'] ;
                unset($_SESSION['mensagem_erro']);
            }
        ?>
    </div>
    <br>
    <button onclick="window.location.href='Busca.php';">Voltar à Busca</button>
    <button onclick="window.location.href='index.php';">Voltar ao Início</button>
</body>
</html>