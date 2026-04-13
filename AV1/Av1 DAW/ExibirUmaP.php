<?php $mostrarPergunta=false;?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Exibir pergunta</title>
</head>
<body>
    <?php if(!$mostrarPergunta):?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <h1>Insira o Id da pergunta a ser alterada</h1>
    <input type="number"  placeholder="id" name="id">
    <button type="submit" name='btO'>Buscar objetiva</button>
    <button type="submit" name='btD'>Buscar Discursiva</button>
    </form>
    <?php endif;?>
    <button onclick="window.location.href='CriarPD.php'">Voltar a criar perguntar discursiva</button>
    <button onclick="window.location.href='CriarPM.php'">Voltar a criar perguntar objetiva</button>
    <button  onclick="window.location.href='index.php'">Voltar ao inicio </button>
</body>
</html>
<?php 

 if($_SERVER['REQUEST_METHOD']=="POST")
        {
            if(file_exists("PerguntaM.txt"))
                {
                    if(isset($_POST['btO']))
                      {      
                        $idPro=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT );
                        $arq=fopen("PerguntaM.txt","r") or die("Erro ao abrir o arquivo");
                         $cabM=fgetcsv($arq,0,";");
                       echo "<table>";
                        if(!empty($cabM))
                        {
                            echo "<tr>";
                                   echo "<th>". htmlspecialchars($cabM[0])."</th>";
                                   echo "<th>". htmlspecialchars($cabM[1])."</th>";
                                   echo "<th>". htmlspecialchars($cabM[3])."</th>";
                                   echo "<th>". htmlspecialchars($cabM[4])."</th>";
                                   echo "<th>". htmlspecialchars($cabM[5])."</th>";
                                   echo "<th>". htmlspecialchars($cabM[6])."</th>";
                                   echo "<th>". htmlspecialchars($cabM[7])."</th>";

                                echo "</tr>";
                        }
                        while(($dados=fgetcsv($arq,0,";"))!==FALSE)
                            {
                                echo "<tr>";
                                 
                                if($dados[0]==$idPro)
                                    {
                                      
                                      echo "<td>". htmlspecialchars($dados[0])."</td>";
                                      echo "<td>". htmlspecialchars($dados[1])."</td>";
                                      echo "<td>". htmlspecialchars($dados[3])."</td>";
                                      echo "<td>". htmlspecialchars($dados[4])."</td>";
                                      echo "<td>". htmlspecialchars($dados[5])."</td>";
                                      echo "<td>". htmlspecialchars($dados[6])."</td>";
                                      echo "<td>". htmlspecialchars($dados[7])."</td>";

                                     echo "</tr>";       
                                     $mostrarPergunta=true;
                                    }
                            
                            }

                        
                               
                            
                            echo "</table>";
                            fclose($arq);
                            if(!$mostrarPergunta)
                                {
                                    $_SESSION['erro']=true;
                                    $_SESSION['mensagem_erro']="Pergunta não encontrada";
                                }
                      } 
                }
                if(file_exists("PerguntaD.txt"))
                    {
                        if(isset($_POST['btD']))
                      {      
                        $idPro=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT );
                        $arq=fopen("PerguntaD.txt","r") or die("Erro ao abrir o arquivo");
                         $cabD=fgetcsv($arq,0,";");
                       echo "<table>";
                        if(!empty($cabD))
                        {
                            echo "<tr>";
                            echo "<th>". htmlspecialchars($cabD[0])."</th>";
                                   echo "<th>". htmlspecialchars($cabD[1])."</th>";
                                echo "</tr>";
                        }
                        while(($dados=fgetcsv($arq,0,";"))!==FALSE)
                            {
                                echo "<tr>";
                                 
                                if($dados[0]==$idPro)
                                    {
                                     echo "<td>". htmlspecialchars($dados[0])."</td>";
                                     echo "<td>". htmlspecialchars($dados[1])."</td>";
                                     echo "</tr>";     
                                     $mostrarPergunta=true;  
                                    }
                            
                            }

                        
                               
                            
                            echo "</table>";
                            fclose($arq);
                            if(!$mostrarPergunta)
                                {
                                    $_SESSION['erro']=true;
                                    $_SESSION['mensagem_erro']="Pergunta não encontrada";
                                }
                      } 
                }   
                    }
         
?>