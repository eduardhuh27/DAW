<?php 
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'daw';
$username = 'root';
$password = '';
try {
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(["sucesso"=>false,"mensagem"=> "Falha  na conexao ". $conn->connect_error]);
    exit;
}


 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $pergunta = htmlspecialchars($_POST['pergunta'] ?? "");
    $resposta = htmlspecialchars($_POST['resposta'] ?? "");

   
    if (empty($id) || empty($pergunta) || empty($resposta)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro: Preencha todos os campos do formulario."]);
        exit;
    }

    
    $comandoSQL=$conn->prepare("INSERT into pergunta_discursiva(id,pergunta,resposta_padrao) values (?,?,?)");

    if($comandoSQL)
        {
            $comandoSQL->bind_param("iss",$id,$pergunta,$resposta);

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

} else {
   
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso negado. Use o formulario."]);
    exit;
}} catch (Exception $e) {
    
    echo json_encode([
        "sucesso" => false, 
        "mensagem" => "ERRO FATAL NO BANCO: " . $e->getMessage()
    ]);
    exit;
}
?>