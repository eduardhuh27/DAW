<?php session_start();?>
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $procurado=filter_input(INPUT_POST,"procurado",FILTER_SANITIZE_NUMBER_FLOAT);
        $_SESSION['encontrou']="O aluno que possui a matricula:".$procurado." é:";
        $arquivo=fopen("alunos.txt","r");
        while(!feof($arquivo))
        {
            
            $dados=fgetcsv($arquivo,0,";");
            if($dados[1]==$procurado)
            {
                $_SESSION['dados']=$dados[0];
                break;
            }
            
        }

    fclose($arquivo);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styleb.css">
</head>
<body>
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Matricula:<input type="text" placeholder="Busca" name="procurado">
        <input type="submit">
    </form>
    <br>
    <button onclick="window.location.href='index.php';">Voltar ao cadastro</button>
    <p><?php echo $_SESSION['encontrou'].$_SESSION['dados']?>
    </p>
</body>
</html>