<?php session_start();?>
<?php 
    $mensagem = "";
    $mostrarFormulario = false;
    $dadosAnt = [];
    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            if(file_exists($_SESSION['nomeArq']))
                {
                if(isset($_POST['btP']))
                {   
                    $procurado=htmlspecialchars($_POST['procura'] ?? "");
                    $arq=fopen($_SESSION['nomeArq'],'r');
                
                    while(($dados= fgetcsv($arq,0,";"))!==FALSE)
                    {
                        if($dados[0]==$procurado)
                         {
                            $dadosAnt=$dados;
                            $mostrarFormulario=true;
                            break;
                         } 
                    }
                    fclose($arq);    
                    if(!$mostrarFormulario)
                    {
                      $mensagem ="Erro: sigla não encontradas";
                    }
                 }
                 
                 
                 if(isset($_POST['btA']))
                    {
                        $nome=htmlspecialchars($_POST["nome"]??"");
                        $sigla=htmlspecialchars($_POST["sigla"] ?? "");
                        $carga=filter_input(INPUT_POST,"carga",FILTER_SANITIZE_NUMBER_INT);
                        $procurado=htmlspecialchars($_POST['procurado'] ?? "");
                        $arq=fopen($_SESSION['nomeArq'],'r');
                        $arqtemp=fopen("temp.txt",'w');
                        $atualizado = false;
                            
                    while (($dados = fgetcsv($arq, 0, ";")) !== FALSE) 
                    {
                    if (isset($dados[0]) && $dados[0] == $procurado) 
                    {
                        $linhaNova = $sigla . ";" . $nome . ";" . $carga . "\n";
                        fwrite($arqtemp, $linhaNova);
                        $atualizado = true;
                    } 
                    else 
                    {
                     
                        if (!empty($dados) && array_filter($dados))
                        {
                            fwrite($arqtemp, implode(";", $dados) . "\n");
                        }
                    }
                    }
                fclose($arq);
                fclose($arqtemp);
                if ($atualizado) 
                {
                    rename("temp.txt", $_SESSION['nomeArq']);
                    $mensagem = "<p>Disciplina atualizada com sucesso!</p>";
                }    
                else 
                {
                    unlink("temp.txt");
                    $mensagem = "<p'>Erro ao atualizar disciplina.</p>";
                }
            }
                  if(isset($_POST['btE']))
                    {
                      
                        $procurado=htmlspecialchars($_POST['procurado'] ?? "");
                        $arq=fopen($_SESSION['nomeArq'],'r');
                        $arqtemp=fopen("temp.txt",'w');
                        $deletado = false;
                            
                    while (($dados = fgetcsv($arq, 0, ";")) !== FALSE) 
                        {
                   
                     if (isset($dados[0]) && $dados[0] == $procurado) 
                    {
                        $deletado = true;
                    }
                    else 
                    { 
                        if (!empty($dados) && array_filter($dados))
                        {
                            fwrite($arqtemp, implode(";", $dados) . "\n");
                        }
                    }
                    }

            fclose($arq);
            fclose($arqtemp);
             if ($deletado) 
            {
                rename("temp.txt", $_SESSION['nomeArq']);
                $mensagem = "<p >Disciplina atualizada com sucesso!</p>";
            }    
            else 
            {
                unlink("temp.txt");
                $mensagem = "<p >Erro ao atualizar disciplina.</p>";          
            }   
              
            }
        }
        }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Busca pela Sigla</h1>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <input type="text" placeholder= "Sigla" name="procura">
        <button type="submit" name="btP">Procurar</button>
    </form>
     <?php echo $mensagem; ?>
    <?php if($mostrarFormulario):?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <input type="hidden" name="procurado" value="<?php echo htmlspecialchars($dadosAnt[0] ?? ""); ?>">
                        <input type="text" placeholder= "Sigla" name="sigla">
                        <input type="text" placeholder= "Nome" name="nome">
                        <input type="number" placeholder= "Carga" name="carga">
                        <br>
                        <button type="submit" name="btA">Atualizar</button>
                        <button type="submit" name="btE">Deletar</button>
                        </form>
    <?php endif; ?>
           <br>
           <button onclick="window.location.href='index.php';">Voltar Cadastro</button>
</body>
</html>