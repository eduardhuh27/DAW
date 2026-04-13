<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                            echo "<td>";
                            foreach($cabM as $coluna)
                                {
                                   echo "<th>". htmlspecialchars($coluna)."</th>";
                                }
                                echo "</td>";
                        }
                        while(($dados=fgetcsv($arqM,0,";"))!==FALSE)
                            {
                                
                            foreach($dados as $valor)
                                {
                                   echo "<tr>". htmlspecialchars($valor)."</tr>";
                                }
                                
                            }

                    echo "</table>";

                    echo "<table>"; 

                    if(!empty($cabD))
                        {
                            echo "<td>";
                            foreach($cabD as $coluna)
                                {
                                   echo "<th>". htmlspecialchars($coluna)."</th>";
                                }
                                echo "</td>";
                        }
                          while(($dados=fgetcsv($arqD,0,";"))!==FALSE)
                            {
                                
                            foreach($dados as $valor)
                                {
                                   echo "<tr>". htmlspecialchars($valor)."</tr>";
                                }
                                

                            }








                    echo "</table>";
               }
                

    ?>
</body>
</html>