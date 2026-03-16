<?php session_start()?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>
<?php 
    $_SESSION['mensagem_erro']="Fim do arquivo alcançado ou erro na leitura.";
    echo "<table>";
        
    if(file_exists("alunos.txt"))
    {
        $arquivo=fopen("alunos.txt","r") or die("Erro ao abrir o arquivo!");
        $cabecalho=fgetcsv($arquivo,0,";") ?? true ;
        echo "<tr>";
        if(!empty($cabecalho))
        {
            foreach($cabecalho as $coluna)
            {
                echo "<th>".htmlspecialchars($coluna)."</th>";
            }
        }
        else
        {
            echo $_SESSION['mensagem_erro'];
            unset($_SESSION['mensagem_erro']);
        }
        echo "</tr>";
        while(($dados = fgetcsv($arquivo, 0, ";")) !== FALSE)
            {
                
                
                if(empty($dados))
                    {
                        echo $_SESSION['mensagem_erro'];
                        unset($_SESSION['mensagem_erro']);
                        break;
                    }
                else
                    {
                        echo "<tr>";
                        foreach($dados as $valor)
                            {
                                echo "<td>".htmlspecialchars($valor)."</td>";
                            }
                        echo "</tr>";
                    }
                        
                
            }
        }
        
        
            echo "</table>";
    if(file_exists("alunos.txt"))
    fclose($arquivo);

    unset($_SESSION['mensagem_erro']);
    ?>
    <button onclick="window.location.href='index.php';">Voltar ao cadastro</button>
    
</body>
</html>