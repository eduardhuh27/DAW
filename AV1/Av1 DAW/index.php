<?php
    session_start();
    $_SESSION['logado']=false;
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
            if( empty($nome) || empty($email) || empty($senha))
                {
                    $_SESSION['erro']=true;
                    $_SESSION['mensagem_erro']="Preencha todos os campos";
                    unset($_POST['btC']);
                }
            if(!$_SESSION['erro'])
                {
                    $arq=fopen("cadastro.txt","a") or die("Erro ao abrir o arquivo");
                    $linha=$nome.";".$email.";".$senha."\n";
                    fwrite($arq,$linha);
                    fclose($arq);
                    $_SESSION['logado']=true;
                    
                }

        }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Inicio</title>
</head>
<body>
    <?php if(!$_SESSION['logado']):?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
    <input type="text" placeholder="Nome" name="nome">
    <input type="text" placeholder="Email" name="email">
    <input type="text" placeholder="Senha" name="senha">
    <button type="submit" name="btC">Cadastrar Usuario</button>
    <?php  endif;
    if($_SESSION['logado'])
        echo "<h1>Usuario cadastrado com sucesso!</h1>"
        ?>
        </form>

    <?php if(!isset($_POST['btC'])) :?>
    <button onclick="window.location.href='CriarPD.php'">Criar pergunta discursiva</button>
    <button onclick="window.location.href='CriarPM.php'">Criar pergunta objetiva</button>
        
    <?php endif;?>
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