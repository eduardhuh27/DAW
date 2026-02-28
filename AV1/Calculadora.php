<?php session_start();?>
<?php

if($_SERVER["REQUEST_METHOD"]=="POST")
    {
    //Serve para filtrar o que será inserido nos campos de input
        $x= filter_input(INPUT_POST,"a",FILTER_SANITIZE_NUMBER_FLOAT);
        $y= filter_input(INPUT_POST,"b",FILTER_SANITIZE_NUMBER_FLOAT);
        $operacao=htmlspecialchars($_POST["operador"]) ?? "";

        //Verificação de erros
        $erros=false;       
        if( $x=="" || $y=="" )
            {
                   $_SESSION['mensagem_erro'] = "Preencha todos os campos para realizar a operação";
                $erros=true;
                } 
                else
                {   
                    if(!is_numeric($x)|| !is_numeric($y))
                    {
                        $_SESSION['mensagem_erro'] ="Apenas escreva números nos campos";
                    }
                   
                       
                    
                }
    
                //Realizando os calculos
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
                    case "multiplicação":
                        $resultado=$x*$y;
                    break;
                    case "divisao":
                         if($y==0) 
                            {
                               $_SESSION['mensagem_erro'] ="Divisão por zero ";
                               $erros=true;
                            }
                        else
                            {
                                $resultado=$x/$y;
                            }
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
            //Exibir o resultado
            if(!$erros)
                {
                    if($operacao=="potencia")
                    {
                        $_SESSION['mensagem_resultado'] = "Resultado: $x^$y = $resultado";            
                    }
                    else{
                        $_SESSION['mensagem_resultado']="Resultado: $operacao de $x e $y= $resultado ";    
                        }
                }
             }
                        header("Location:".$_SERVER['PHP_SELF']);
                        exit;
                        }
                        ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <body <style background-color: darkslategrey</style>
        <div class="formulario">
            Minha Calculadora!  
            <!-- Isso serve para evitar codigos maliciosos -->
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
                <input type="number" name="a"
                placeholder="Primeiro número">
                <input type="number" name="b"
                placeholder="Segundo número">
                <br>
                <select name="operador">
                    <option value="soma">Somar</option>
                    <option value="subtracao">Subtrair</option>
                    <option value="multiplicação">Multiplicar</option>
                    <option value="divisao">Dividir</option>
                    <option value="potencia">Potência</option>
                </select>
                <button>Calcular</button>
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
            </div>
</form>
</body>
</html>