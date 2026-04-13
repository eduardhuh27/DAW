<?php
 session_start();
    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $_SESSION['erro']=false;
            $pergunta=htmlspecialchars($_POST['pergunta']?? "");
            $oA=htmlspecialchars($_POST['a']?? "");
            $oB=htmlspecialchars($_POST['b']?? "");
            $oC=htmlspecialchars($_POST['c']?? "");
            $oD=htmlspecialchars($_POST['d']?? "");
            $oE=htmlspecialchars($_POST['e']?? "");
            $resposta=htmlspecialchars($_POST['resposta']?? "");
            $id=filter_input(INPUT_POST,'id',FILTER_SANITIZE_NUMBER_INT);
            if(!file_exists("PerguntaM.txt"))
            {
                $arq=fopen("PerguntaM.txt","w") or die("Erro ao abrir o arquivo");
                $linha="id;pergunta;resposta;A;B;C;D;E\n";
                fwrite($arq,$linha);
                fclose($arq);
            }
            if(empty($id) || empty($pergunta)||empty($oA) ||empty($oB) ||empty($oC) ||empty($oD) ||empty($oE) ||empty($resposta))
                {
                    $_SESSION['erro']=true;
                    $_SESSION['mensagem_erro']="Preencha todos os campos";
                }
            if(!$_SESSION['erro'])
                {
                    $arq=fopen("PerguntaM.txt","a") or die("Erro ao abrir o arquivo");
                    $linha=$id.";".$pergunta.";".$oA.";".$oB.";".$oC.";".$oD.";".$oE.";".$resposta."\n";
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
    
    <title>Criar pergunta objetiva</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="number" placeholder="Id" name="id">
    <input type="text" placeholder="Cabeçalho da pergunta" name="pergunta">
    <br>
    <input type="text" placeholder="A" name="a">
    <input type="text" placeholder="B" name="b">
    <input type="text" placeholder="C" name="c">
    <input type="text" placeholder="D" name="d">
    <input type="text" placeholder="E" name="e">
    <input type="text" placeholder="Resposta correta" name="resposta">
    <button type="submit" >Criar pergunta objetiva</button>
</form>
<button onclick="window.location.href='AlterarPM.php'">Alterar perguntar objetiva</button>
<button onclick="window.location.href='ExibirP.php'">Exibir perguntas </button>
<button onclick="window.location.href='ExibirUmaP.php'">Exibir pergunta</button>
<button  onclick="window.location.href='index.php'">Voltar ao inicio </button>
</body>
</html>