<?php session_start();?>
<?php

        if ($_SERVER['REQUEST_METHOD'] == 'POST')
              {

                    $nome = htmlspecialchars($_POST["nome"] ?? "");
                    $matricula =filter_input(INPUT_POST,"matricula", FILTER_SANITIZE_NUMBER_INT);
                    $email = htmlspecialchars($_POST["email"] ?? "");
                    $msg = "";
                   // echo "nome: " . $nome ."\n" . " Matricula: " .$matricula."\n"  . " email: " . $email."\n";
                   $_SESSION['erros']=false;
                   if($matricula=="")
                    {
                        $_SESSION['mensagem_erro']="Erro: a matricula deve possuir apenas numeros";
                        $_SESSION['erros']=true;
                    }
            if(!$_SESSION['erros'])
                {
                    if (!file_exists("alunos.txt")) 
                    {
                        $arqDisc = fopen("alunos.txt","w") or die("erro ao criar arquivo");
                        $linha = "nome;matricula;email\n";
                        fwrite($arqDisc,$linha);
                        fclose($arqDisc);
                    }

                    $arqDisc = fopen("alunos.txt","a") or die("erro ao criar arquivo");
                    $_SESSION['linha'] = $nome . ";" . $matricula . ";" . $email . "\n";
                    fwrite($arqDisc,$_SESSION['linha']);
                    unset($_SESSION['linha']);
                    fclose($arqDisc);
                    $_SESSION['mensagem_resultado'] = "Deu tudo certo!!!";
                   }
                   header("Location: " . $_SERVER['PHP_SELF']);
                    exit;
             }
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="stylec.css">
</head>
<body>
<h1>Cadastrar novos alunos</h1>
<form  method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Nome: <input type="text" name="nome">
    <br><br>
    Matricula: <input type="text" name="matricula">
    <br><br>
    Email: <input type="text" name="email">
    <br><br>
    <input type="submit" value="Criar Nova Disciplina">
</form>
<button onclick="window.location.href='exibirAlunos.php';">Exibir tabela
</button>
<button onclick="window.location.href='Busca.php';">Procurar aluno pela matricula
</button>
<p>
    <?php
        if(isset($_SESSION['mensagem_resultado']))
           {
            echo"<div class='resultado'>". $_SESSION['mensagem_resultado']."</div>";
            unset($_SESSION['mensagem_resultado']);
           }
           if(isset($_SESSION['mensagem_erro']))
            {
                echo"<div class='resultado'>". $_SESSION['mensagem_erro']."</div>";
                unset($_SESSION['mensagem_erro']);
            }
    ?>
</p>
<br>
</body>
</html>