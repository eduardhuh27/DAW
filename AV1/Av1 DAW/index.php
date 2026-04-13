<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $_SESSION['erro']=false;
            $nome=htmlspecialchars($_POST['nome']?? "");
            $email=htmlspecialchars($_POST['email']?? "");
            $senha=htmlspecialchars($_POST['senha']?? "");
            if(!file_exists("cadastro.txt"))
            {
                $arq=fopen("cadastro.txt","w") or die("Erro ao abrir o arquivo");
                $linha="nome;email;senha\n";
                fwrite($arq,$linha);
                fclose($arq);
            }
            if(empty($nome) || empty($email)|| empty($senha))
                {
                    $_SESSION['erro']=true;
                    $_SESSION['mensagem_erro']="Preencha todos os campos";
                }
            if(!$_SESSION['erro'])
                {
                    $arq=fopen("cadastro.txt","a") or die("Erro ao abrir o arquivo");
                    $linha=$nome.";".$email.";".$senha."\n";
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
    <title>Document</title>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="text" placeholder="Nome" name="nome">
    <input type="text" placeholder="Email" name="email">
    <input type="text" placeholder="Senha" name="senha">
    <button type="submit" name="btC">Cadastrar Usuario</button>
    </form>
    <?php if(isset($_POST['btC'])) :?>
    <button onclick="window.location.href='CriarPD.php'">Criar perguntar discursiva</button>
    <button onclick="window.location.href='CriarPM.php'">Criar perguntar objetiva</button>
    <button onclick="window.location.href='AlterarPD.php'">Alterar perguntar discursiva</button>
    <button onclick="window.location.href='AlterarPM.php'">Alterar perguntar objetiva</button>
    <button onclick="window.location.href='ExibirP.php'">Exibir perguntas </button>
    <button onclick="window.location.href='ExibirUmaP.php'">Exibir pergunta</button>
    <?php endif; ?>
</body>
</html>