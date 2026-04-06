<?php
    $nomeArq = "dados.txt";

    if($_SERVER["REQUEST_METHOD"]=="POST")
        {
            $nome=$_POST["nome"];
            $sigla=$_POST["sigla"];
            $carga=$_POST["carga"];
            
            if(!file_exists($nomeArq))
                {
                    $arq=fopen($nomeArq,"w");
                    $cabecalho="Sigla;Nome;Carga\n";
                    fwrite($arq,$cabecalho);
                    fclose($arq);
                }
            $arq=fopen($nomeArq,"a");
            $linha=$nome.";".$sigla.";".$carga."\n";
            fwrite($arq,$linha);
            fclose($arq);
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
    <form method="POST">
    <input type="text" placeholder="Nome" name="nome">
    <input type="text" placeholder="Sigla" name="sigla">
    <input type="number" placeholder="Carga" name="carga">
    <button type="submit">Cadastrar 
    </form>
</body>
</html>