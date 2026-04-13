<?php 
    session_start();
    $mostrarformulario=false;
    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            if(file_exists("PerguntaM.txt"))
                {
                    if(isset($_POST['btB']))
                      {      
                        $idPro=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT );
                        $arq=fopen("PerguntaM.txt","r") or die("Erro ao abrir o arquivo");
                       

                        while(($dados=fgetcsv($arq,0,";"))!==FALSE)
                            {
                                
                                if($dados[0]==$idPro)
                                    {
                                        $_SESSION['id_procurado']=$dados;
                                        $mostrarformulario=true;
                                        break;
                                    }
                            }
                            fclose($arq);
                            if(!$mostrarformulario)
                                {
                                    $_SESSION['erro']=true;
                                    $_SESSION['mensagem_erro']="Pergunta não encontrada";
                                }
                      }  
                      if(isset($_POST['btA']))
                            {
                                $pergunta=htmlspecialchars($_POST['pergunta']?? "");
                                 $oA=htmlspecialchars($_POST['a']?? "");
                                $oB=htmlspecialchars($_POST['b']?? "");
                                $oC=htmlspecialchars($_POST['c']?? "");
                                $oD=htmlspecialchars($_POST['d']?? "");
                                $oE=htmlspecialchars($_POST['e']?? "");
                                 $resposta=htmlspecialchars($_POST['resposta']?? "");
                                $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
                                $arq=fopen("PerguntaM.txt","r") or die("Erro ao abrir o arquivo");
                                $arqt=fopen("temp.txt","w") or die("Erro ao abrir o arquivo");
                                $atualizado=false;

                                while(($dados=fgetcsv($arq,0,";"))!==FALSE)
                                {
                                    if($dados[0]==$id)
                                        {
                                        $linha=$id.";".$pergunta.";".$oA.";".$oB.";".$oC.";".$oD.";".$oE.";".$resposta."\n";
                                        fwrite($arqt,$linha);
                                        $atualizado=true;
                                        }
                                    else fwrite($arqt,implode(";",$dados)."\n");
                                }
                                fclose($arq);
                                fclose($arqt);
                                if($atualizado) rename("temp.txt","PerguntaM.txt");
                                else{
                                    unlink("temp.txt");
                                    $_SESSION['erro']=true;
                                    $_SESSION['mensagem_erro']="Erro ao atualizar.";
                                }
                            }
                        if(isset($_POST['btD']))
                            {
                             $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
                                $arq=fopen("PerguntaM.txt","r") or die("Erro ao abrir o arquivo");
                                $arqt=fopen("temp.txt","w") or die("Erro ao abrir o arquivo");
                                 $deletado=false;

                                while(($dados=fgetcsv($arq,0,";"))!==FALSE)
                                {
                                    if($dados[0]==$id)
                                        {
                                        $deletado=true;
                                        }
                                    else fwrite($arqt,implode(";",$dados)."\n");
                                }
                                fclose($arq);
                                fclose($arqt);
                                if($deletado) rename("temp.txt","PerguntaM.txt");
                                else{
                                    unlink("temp.txt");
                                    $_SESSION['erro']=true;
                                    $_SESSION['mensagem_erro']="Erro ao deletar.";
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
    
    <title>Alterar pergunta objetiva</title>
</head>
<body>
    <?php if(!$mostrarformulario):?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
        <h1>Insira o Id da pergunta a ser alterada</h1>
    <input type="number"  placeholder="id" name="id">
    <button type="submit" name='btB'>Buscar</button>
    </form>
    <?php endif;?>
<?php if($mostrarformulario):?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
    <input type="number" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][0]);?>" name="id" readonly>
    <input type="text" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][1]);?>" name="pergunta">
    <input type="text" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][2]);?>" name="resposta">
    <input type="text" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][3]);?>" name="a">
    <input type="text"value="<?php echo htmlspecialchars($_SESSION['id_procurado'][4]);?>" name="b">
    <input type="text" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][5]);?>" name="c">
    <input type="text" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][6]);?>" name="d">
    <input type="text" value="<?php echo htmlspecialchars($_SESSION['id_procurado'][7]);?>" name="e">
    <button type="submit" name='btA'>Atualizar</button>
    <button type="submit" name='btD'>Deletar</button>
    </form>
    <?php endif;?>
    <button onclick="window.location.href='CriarPM.php'">Voltar a criação de perguntas</button>
    <button  onclick="window.location.href='index.php'">Voltar ao inicio </button>
     <?php
    if($_SESSION['erro'])
        {
            if(isset($_SESSION['mensagem_erro']))
                {
                    echo htmlspecialchars($_SESSION['mensagem_erro']);
                    unset($_SESSION['mensagem_erro']);
                }
        } 
        ?>
</body>
</html>