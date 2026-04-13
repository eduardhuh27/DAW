<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        session_start();

        if(file_exists($_SESSION['nome_arq']))
            {
                $arq=fopen($_SESSION['nome_arq'],"r");
                $cabecalho=fgetcsv($arq,0,";");
                echo "<table>";
                if(!empty($cabecalho))
                    {
                        echo "<tr>";
                        foreach($cabecalho as $coluna)
                            {
                                echo "<th>".$coluna."</th>";
                            }
                        echo "</tr>";                    
                    }
                while(($item=fgetcsv($arq,0,";"))!==FALSE)
                    {
                        echo "<tr>";
                        foreach($item as $valor)
                            {
                                echo "<td>".$valor."</td>";
                            }
                            echo "</tr>";
                    }
            }
    

        echo "</table>";
    ?>
    <button onclick="window.location.href='index.php'">Voltar ao inicio</button>
</body>
</html>