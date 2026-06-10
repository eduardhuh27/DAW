<?php 
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'daw';
$username = 'root';
$password = '';


$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["sucesso"=>false,"mensagem"=> "Falha  na conexao ". $conn->connect_error]);
    exit;
}


if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['acao'])) {
    header('Content-Type: application/json');
    
    $acao = $_POST['acao'];
    $resposta_json = ['sucesso' => false, 'mensagem' => ''];

 if($acao == 'buscar') {
        $idPro = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $encontrado = false;
        
          $comandoSQL=$conn->prepare("SELECT * FROM pergunta_objetiva WHERE id=?");

    if($comandoSQL)
        {
            $comandoSQL->bind_param("i",$idPro);

            $comandoSQL->execute();
            
            $resultado = $comandoSQL->get_result();

        if ($linha = $resultado->fetch_assoc()) {
            $resposta_json = [
                    'sucesso' => true,
                    'dados' => [
                        'id' => $linha[0],
                        'pergunta' => $linha[1],
                        'resposta' => $linha[2],
                        'a'=>$linha[3],'b'=>$linha[4],'c'=>$linha[5],'d'=>$linha[6],'e'=>$linha[7]
                    ]
                ];
            }   
                
          else{
                    echo json_encode(["sucesso" => false, "mensagem" => "Erro ao achar pergunta". $comandoSQL->error]);
                }
            $comandoSQL->close();
            exit;
        }
        else{
            echo json_encode(["sucesso"=>false,"mensagem"=>"Erro ao montar o query"]);
        }


        }

        if($acao == 'atualizar') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $pergunta = htmlspecialchars($_POST['pergunta'] ?? "");
            $resposta = htmlspecialchars($_POST['resposta'] ?? "");
             $a = htmlspecialchars($_POST['a'] ?? "");
            $b = htmlspecialchars($_POST['b'] ?? "");
            $c = htmlspecialchars($_POST['c'] ?? "");
            $d = htmlspecialchars($_POST['d'] ?? "");
            $e = htmlspecialchars($_POST['e'] ?? "");
        
            $atualizado = false;
           
        if (empty($id) || empty($pergunta) || empty($resposta)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro: Preencha todos os campos do formulario."]);
            exit;
        }

        try {
            $comandoSQL=$conn->prepare("UPDATE `pergunta_objetiva` SET  `pergunta`= ?, `resposta_padrao`=?,`a`=?,`b`=?,`c`=?,`d`=?,`e`=? WHERE `pergunta_objetiva`.`id` = ? ");

         if($comandoSQL)
        {
            $comandoSQL->bind_param("sssssssi",$pergunta,$resposta,$id,$a,$b,$c,$d,$e,$id);

            if($comandoSQL->execute())
                {
                    $conn->commit();
                    echo json_encode(["sucesso" => true, "mensagem" => "Pergunta discursiva salva com sucesso!"]);
                }
                else{
                    echo json_encode(["sucesso" => false, "mensagem" => "Erro ao salvar pergunta". $comandoSQL->error]);
                }
            $comandoSQL->close();
        }
        else{
            echo json_encode(["sucesso"=>false,"mensagem"=>"Erro ao montar o query"]);
        }


        $conn->close();
        exit;
        }catch (Exception $e) {
    
        echo json_encode([
            "sucesso" => false, 
            "mensagem" => "ERRO FATAL NO BANCO: " . $e->getMessage()
        ]);
        exit;
        }
        }
        if($acao == 'deletar') {
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $deletado = false;
            try{
            $comandoSQL=$conn->prepare("DELETE FROM pergunta_objetiva WHERE `pergunta_objetiva`.`id` = ?");

            if($comandoSQL)
            {
            $comandoSQL->bind_param("i",$id);

            if($comandoSQL->execute())
                if ($comandoSQL->affected_rows > 0) {
                echo json_encode(["sucesso" => true, "mensagem" => "Pergunta discursiva deletada com sucesso!"]);
                }
            else{
                echo json_encode(["sucesso" => false, "mensagem" => "Erro ao deletar pergunta".$comandoSQL->error]);
            }
            $comandoSQL->close();
            }
             $conn->close();
        exit;

            } catch (Exception $e) {
    
                echo json_encode([
                    "sucesso" => false, 
                    "mensagem" => "ERRO FATAL NO BANCO: " . $e->getMessage()
                ]);
                exit;
                }  
        
        }
        }
    
?>