<?php
    session_start();
    $_SESSION['erro']=false;

    if($_SERVER['REQUEST_METHOD']=="POST")
        {
            $nome=htmlspecialchars($_POST['nome']?? "");
            $email=htmlspecialchars($_POST['email']?? "");
            $senha=htmlspecialchars($_POST['senha']?? "");
            $_SESSION['logado']=false;
            $arqV=fopen("senha.txt","r");
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

                    
                while(($login=fgetcsv($arqV,0,";"))!==FALSE)
                    {   
                        if($login[0]==$nome && $login[1]==$senha){
                            $_SESSION['logado']=true;
                            break;
                        }

                    }
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
    <link rel="stylesheet" href="style.css">
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
    if($_SESSION['logado'] && isset($_POST['btC']) ){
        echo "<h1>Login realizado com sucesso!</h1>";
        }
    if(!$_SESSION['logado'] && isset($_POST['btC'])) {echo "<h1>Usuario ou senha errados!</h1>";}
    ?>
        </form>

    <?php if(isset($_POST['btC']) &&  $_SESSION['logado']) :?>
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