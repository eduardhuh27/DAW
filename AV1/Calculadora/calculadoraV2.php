<?php
// Diz pro php que não será exibido um pagina mas será tratamento de dados
header('Content-Type: application/json');

if($_SERVER["REQUEST_METHOD"]=="GET")
    {
    //Serve para filtrar o que será inserido nos campos de input
        $x= filter_input(INPUT_GET,"a",FILTER_SANITIZE_NUMBER_FLOAT);
        $y= filter_input(INPUT_GET,"b",FILTER_SANITIZE_NUMBER_FLOAT);
        $operacao=htmlspecialchars($_GET["operador"]) ?? "";

        //Verificação de erros
        $erros=false;       
        if( $x=="" || $y=="" )
            {
                //Faz um JSON com dizendo se a operção foi um sucesso e com a mensagem/resultado
                   echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos com números válidos."]);
                exit;
            }
            $resultado = 0;
            $erros = false;
            $mensagem = "";

                //Realizando os calculos
                        
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
                               $mensagem = "Operação inválida.";
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
                            //poderia usar a função pow
                            //pow($x,$y);
                        $resultado=$resultado*$x;
                        $y--;       
                        }while($y>1);
                    }
                    case"raiz":
                        if ($y == 0) 
                        {
                            $erros = true;
                            $mensagem = "O índice da raiz não pode ser zero.";
                            break;
                        }
                        $resultado= pow($x,(1/$y));
                    break;
                    default:
                        $mensagem = "Operação inválida.";
                        $erros=true;     
                }
            //Exibir o resultado
            if(!$erros)
                {
                    echo json_encode(["sucesso" => true, "resultado" => $resultado]);
                    }
                    else{
                        echo json_encode(["sucesso" => false, "mensagem" => $mensagem]);                   
                }
                }
                        
                        ?>
                       
