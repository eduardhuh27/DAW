<?php session_start();?>
<?php
    if(file_exists($_SESSION['nomeArq']))
        {

            $arq=fopen($_SESSION['nomeArq'],"r") or die("Erro ao abrir o arquivo!");
            $cabecalho= fgetcsv($arq,0,";") ?? true;
            
            foreach ($cabecalho as $coluna)
            {
                echo htmlspecialchars($coluna)."\t";
            }
                echo "<br>";
                while(($dados=fgetcsv($arq,0,";"))!==FALSE)
                {
                    foreach($dados as $valor)
                    {
                        echo htmlspecialchars($valor)."\t";
                    }
                    echo "<br>";
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
    <button onclick="window.location.href='index.php';">Voltar Cadastro</button>
</body>
</html>