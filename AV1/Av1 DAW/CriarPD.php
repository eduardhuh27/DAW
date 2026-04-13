<?php
 session_start();
    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $_SESSION['erro']=false;
            $pergunta=htmlspecialchars($_POST['pergunta']?? "");
            $resposta=htmlspecialchars($_POST['resposta']?? "");
            $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
            if(!file_exists("PerguntaD.txt"))
            {
                $arq=fopen("PerguntaD.txt","w") or die("Erro ao abrir o arquivo");
                $linha="id;pergunta;resposta\n";
                fwrite($arq,$linha);
                fclose($arq);
            }
            if(empty($id) || empty($pergunta)|| empty($resposta))
                {
                    $_SESSION['erro']=true;
                    $_SESSION['mensagem_erro']="Preencha todos os campos";
                }
            if(!$_SESSION['erro'])
                {
                    $arq=fopen("PerguntaD.txt","a") or die("Erro ao abrir o arquivo");
                    $linha=$id.";".$pergunta.";".$resposta."\n";
                    fwrite($arq,$linha);
                    fclose($arq);
                    
                }

        }
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Criar pergunta discursiva</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="number" placeholder="Id" name="id">
    <input type="text" placeholder="Cabeçalho da pergunta" name="pergunta">
    <input type="text" placeholder="Modelo de resposta" name="resposta">
    <button type="submit" >Criar pergunta discursiva</button>
</form>    
  <button onclick="window.location.href='AlterarPD.php'">Alterar perguntar discursiva</button>
  <button onclick="window.location.href='ExibirUmaP.php'">Exibir pergunta</button>
  <button onclick="window.location.href='ExibirP.php'">Exibir perguntas e respostas </button>
<button  onclick="window.location.href='index.php'">Voltar ao inicio </button>
</body>
</html>