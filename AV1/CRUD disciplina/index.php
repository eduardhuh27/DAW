<?php session_start();?>
<?php
    $_SESSION['nomeArq'] = "dados.txt";

    if($_SERVER["REQUEST_METHOD"]=="POST")
        {
            $nome=htmlspecialchars($_POST["nome"]??"");
            $sigla=htmlspecialchars($_POST["sigla"] ?? "");
            $carga=filter_input(INPUT_POST,"carga",FILTER_SANITIZE_NUMBER_INT);
            $_SESSION["erro"]=false;

            if(empty($nome)|| empty($sigla) || empty($carga))
                {
                    $_SESSION['msg_erro']="ERRO:todos campos do formulario devem ser preenchidos";
                    $_SESSION["erro"]=true;
                }

        if(!$_SESSION["erro"])
            {
            if(!file_exists($_SESSION['nomeArq']))
                {
                    $arq=fopen($_SESSION['nomeArq'],"w");
                    $cabecalho="Sigla;Nome;Carga\n";
                    fwrite($arq,$cabecalho);
                    fclose($arq);
                }
            $arq=fopen($_SESSION['nomeArq'],"a");
            $linha=$sigla.";".$nome.";".$carga."\n";
            fwrite($arq,$linha);
            fclose($arq);
            }
            header("Location: ". $_SERVER["PHP_SELF"]);
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
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <input type="text" placeholder="Nome" name="nome">
    <input type="text" placeholder="Sigla" name="sigla">
    <input type="number" placeholder="Carga" name="carga">
    <button type="submit">Cadastrar</button>
    <br>
    </form>
    <button onclick="window.location.href='Exibir.php';">Exibir Disciplinas</button>
    <button onclick="window.location.href='Atualizar.php';">Atualizar Disciplinas</button>
        <?php 
            if(isset($_SESSION['msg_erro']))
                {
                    echo $_SESSION['msg_erro'];
                    unset($_SESSION['msg_erro']);
                }
        ?>
</body>
</html>
