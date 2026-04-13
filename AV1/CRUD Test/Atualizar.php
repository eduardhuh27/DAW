<?php 
    session_start();
    $mostrarFormulario=false;
    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            if(file_exists($_SESSION['nome_arq']))
                {
                    if(isset($_POST['btB']))
                    {
                        $arq=fopen($_SESSION['nome_arq'],"r");
                        $nomeB=$_SERVER['busca']=htmlspecialchars($_POST['nome'] ?? "");

                        while(($item=fgetcsv($arq,0,";"))!==FALSE)
                            {
                                if($item[0]==$nomeB)
                                    {
                                        $_SESSION['valor_formulario']=$item;
                                        $mostrarFormulario=true;
                                        break;
                                    }
                            }
                        fclose($arq);
                        if(!$mostrarFormulario)
                            {
                                $_SESSION['erros']=true;
                                $_SESSION['mensagem_erro']="Item não pretence a lista";
                            }
                    }
                    if(isset($_POST['btA']))
                        {
                            
                            $nome=htmlspecialchars($_POST['nome'] ?? "");
                            $id=htmlspecialchars($_POST['id'] ?? "");
                            $valor=filter_input(INPUT_POST,'valor',FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                            $arqtemp=fopen("temp.txt","w");
                            $arq=fopen($_SESSION['nome_arq'],"r");
                            $atualizado=false;

                            while(($item=fgetcsv($arq,0,";"))!==FALSE)
                            {
                                if($item[0]==($_SESSION['valor_formulario'][0]))
                                    {
                                        $linha=$nome.";".$id.";".$valor."\n";
                                        fwrite($arqtemp,$linha);
                                        $atualizado=true;
                                    }
                                else
                                    {
                                        fwrite($arqtemp,implode(";",$item)."\n");
                                    }

                            }
                            fclose($arq);
                            fclose($arqtemp);
                            if($atualizado)
                            {
                                rename("temp.txt",$_SESSION['nome_arq']);
                            }
                            else{
                                unlink("temp.txt");
                                $_SESSION['erros']=true;
                                $_SESSION['mensagem_erro']="Item não pretence a lista";
                            }

                        }
                        if(isset($_POST['btE']))
                        {
                            $arqtemp=fopen("temp.txt","w");
                            $arq=fopen($_SESSION['nome_arq'],"r");
                            $deletado=false;

                            while(($item=fgetcsv($arq,0,";"))!==FALSE)
                            {
                                if($item[0]==($_SESSION['valor_formulario'][0]))
                                    {
                                        $deletado=true;
                                    }
                                else
                                    {
                                        fwrite($arqtemp,implode(";",$item)."\n");
                                    }

                            }
                            
                            fclose($arq);
                            fclose($arqtemp);
                            if($deletado)
                            {
                                rename("temp.txt",$_SESSION['nome_arq']);
                            }
                            else{
                                unlink("temp.txt");
                                $_SESSION['erros']=true;
                                $_SESSION['mensagem_erro']="Item não pretence a lista";
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
    <?php if(!$mostrarFormulario):?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ;?>">

    <input type="text" placeholder="Nome" name="nome">
    <button type="submit" name="btB">Buscar</button>    
</form>
<?php endif;?>
<?php if($mostrarFormulario):?>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ;?>">
    <input type="text" name="nome" value="<?php echo htmlspecialchars($_SESSION['valor_formulario'][0] ?? "");?>">
    <input type="text" name="id" value="<?php echo htmlspecialchars($_SESSION['valor_formulario'][1] ?? "");?>">
    <input type="number" step="any" name="valor" value="<?php echo htmlspecialchars($_SESSION['valor_formulario'][2] ?? "");?>">
    <button type="submit" name="btA">Atualizar</button>
    <button type="submit" name="btE">Deletar</button>
    </form>
<?php endif;?>
<?php if($_SESSION['erros'])
{
    if(isset($_SESSION['mensagem_erro'])){
    echo $_SESSION['mensagem_erro'];
    unset ($_SESSION['mensagem_erro']);}
}
?>
</body>
</html>