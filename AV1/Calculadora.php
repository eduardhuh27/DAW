<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body> 
  <div id="formulario">
    Minha Calculadora!  
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
    <input type="number" name="a"
    placeholder="Primeiro número">
    <input type="number" name="b"
    placeholder="Segundo número">
    <br>
    <select name="operador">
       <option value="soma">Somar</option>
       <option value="subtracao">Subtrair</option>
       <option value="multiplicacao">Multiplicar</option>
       <option value="divisao">Dividir</option>
       <option value="potencia">Potência</option>
    </select>
    <button>Calcular</button>
</form>
  </div>
    <?php
        if($_SERVER["REQUEST_METHOD"]="POST")
            {
                $x= filter_input(INPUT_POST,"a",FILTER_SANITIZE_NUMBER_FLOAT);
                $y= filter_input(INPUT_POST,"b",FILTER_SANITIZE_NUMBER_FLOAT);
                $operacao=htmlspecialchars($_POST["operador"]);
                }
         
         $erros=false;       
        if(empty($x) ||empty($y) || empty($operacao))
        {
            echo"<div class='resultado'>Preencha todos os campos para realizar a operação</div>";
            $erros=true;
        } 
        else{   
        if(!is_numeric($x)|| !is_numeric($y))
            {
                echo "<div class='resultado'>Apenas escreva números nos campos</div>";
            }}
        if(!$erros)
            {
                $resultado=0;

                switch($operacao)
                {
                    case "soma":
                        $resultado=$x+$y;
                        break;
                    case "subtracao":
                        $resultado=$x-$y;
                        break;
                     case "multiplicacao":
                        $resultado=$x*$y;
                        break;
                    case "divisao":
                        $resultado=$x/$y;
                        break;
                    case "potencia":
                        $resultado=$x;   
                        if($y>1)
                        { 
                            do{
                                $resultado=$resultado*$x;
                                $y--;       
                            }while($y>1);
                        }
                        break;
                    default:
                        echo"ERRO";     
                }
                if($operacao=="potencia")
                    {
                        echo "<div class='resultado'>Resultado:".$x."^" .$y ."=".$resultado ."</div>";            
                    }
                    else{
                     echo "<div class='resultado'>Resultado:".$operacao. " de ". $x ." e ".$y." = " .$resultado ."</div>";    
                    }
     }
    ?>
</body>
</html>