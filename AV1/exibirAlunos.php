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

        $arquivo=fopen("alunos.txt","r") or die("Erro ao abrir o arquivo!");
        
        $cabecalho=fgetcsv($arquivo,0,";");
        echo "<tr>";
        foreach($cabecalho as $coluna)
            {
                echo "<th>".htmlspecialchars($coluna)."</th>";
            }
        echo "</tr>";
        
        while(!feof($arquivo))
            {
                
                $dados=fgetcsv($arquivo,0,";");
                if(empty($dados))
                    {
                        echo $_SESSION['mensagem_erro'];
                        unset($_SESSION['mensagem_erro']);
                        echo "</table>"; 
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
            echo "</table>";

    fclose($arquivo);


    ?>
    <button onclick="window.location.href='index.php';">Voltar ao cadastro</button>
    
</body>
</html>