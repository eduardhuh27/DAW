<?php 
session_start();

    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $nome=htmlspecialchars($_POST['nome'] ?? "");
            $id=htmlspecialchars($_POST['id'] ?? "");
            $valor=filter_input(INPUT_POST,'valor',FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $_SESSION['erros']=false;
            $_SESSION['nome_arq']="encarte.txt";
            
            if(empty($valor)|| empty($id) || empty($nome))
                {
                    $_SESSION['erros']=true; 
                    $_SESSION['mensagem_erro']="Preencha todos os campos.";
                }   
            if(!$_SESSION['erros'])
                {
                    if(!file_exists($_SESSION['nome_arq']))
                    {
                        $arq=fopen($_SESSION['nome_arq'],"w")or die("Erro ao abrir o arquivo");
                        $cabecalho="nome;id;valor\n";
                        fwrite($arq,$cabecalho);
                        fclose($arq);
                    }
                    $arq=fopen($_SESSION['nome_arq'],"a") or die("Erro ao abrir o arquivo");
                    $linha=$nome.";".$id.";".$valor."\n";
                    fwrite($arq,$linha);
                    fclose($arq);
                }
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
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
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <input type="text" placeholder="Nome do produto" name="nome">
    <br>
    <input type="text" placeholder="Id" name="id">
    <br>
    <input type="number" step="any" placeholder="Preço" name="valor">
    <br>
    <button type="submit">Inserir item</button>
    <button type="button" onclick="window.location.href='Exibir.php'">Exibir itens</button>
    <button type="button" onclick="window.location.href='Atualizar.php'">Atualizar itens</button>
    </form> 
    <?php 
        if($_SESSION['erros'])
            {
                echo $_SESSION['mensagem_erro'];
                $_SESSION['mensagem_erro']="";
            }
    ?>
</body>
</html>