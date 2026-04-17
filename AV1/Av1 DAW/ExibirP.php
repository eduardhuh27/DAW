<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Exibir perguntas e respotas</title>
</head>
<body>
    <?php
            if(file_exists('PerguntaM.txt') && file_exists('PerguntaD.txt'))
               {
                    $arqM=fopen("PerguntaM.txt",'r') or die("Erro ao abrir o arquivo");
                    $arqD=fopen("PerguntaD.txt",'r')or die("Erro ao abrir o arquivo");
                    $cabM=fgetcsv($arqM,0,";");
                    $cabD=fgetcsv($arqD,0,";");

                    echo "<table>";
                    if(!empty($cabM))
                        {
                            echo "<tr>";
                            foreach($cabM as $coluna)
                                {
                                   echo "<th>". htmlspecialchars($coluna)."</th>";
                                }
                                echo "</tr>";
                        }
                        while(($dados=fgetcsv($arqM,0,";"))!==FALSE)
                            {
                                echo "<tr>";
                            foreach($dados as $valor)
                                {
                                   echo "<td>". htmlspecialchars($valor)."</td>";
                                }
                                echo "</tr>";
                            }

                    echo "</table>";

                    echo "<table>"; 

                    if(!empty($cabD))
                        {
                            echo "<tr>";
                            foreach($cabD as $coluna)
                                {
                                   echo "<th>". htmlspecialchars($coluna)."</th>";
                                }
                                echo "</tr>";
                        }
                          while(($dados=fgetcsv($arqD,0,";"))!==FALSE)
                            {
                                echo "<tr>";
                            foreach($dados as $valor)
                                {
                                   echo "<td>". htmlspecialchars($valor)."</td>";
                                }
                                echo "</tr>";

                            }








                    echo "</table>";
               }
                

    ?>
    <button onclick="window.location.href='CriarPD.php'">Voltar a criar perguntas discursivas</button>
    <button onclick="window.location.href='CriarPM.php'">Voltar a criar perguntas objetivas</button>
    <button  onclick="window.location.href='index.php'<?php $_SESSION['logado']=false;?>">Voltar ao inicio </button>
</body>
</html>