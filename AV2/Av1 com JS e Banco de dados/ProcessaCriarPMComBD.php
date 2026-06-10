<?php 
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'daw';
$username = 'root';
$password = '';

try{
$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo json_encode(["sucesso"=>false,"mensagem"=> "Conexão realizada com sucesso!"]);

 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    
    $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
    $pergunta = htmlspecialchars($_POST['pergunta'] ?? "");
    $oA = htmlspecialchars($_POST['a'] ?? "");
    $oB = htmlspecialchars($_POST['b'] ?? "");
    $oC = htmlspecialchars($_POST['c'] ?? "");
    $oD = htmlspecialchars($_POST['d'] ?? "");
    $oE = htmlspecialchars($_POST['e'] ?? "");
    $resposta = htmlspecialchars($_POST['resposta'] ?? "");

    if (empty($id) || empty($pergunta) || empty($oA) || empty($oB) || empty($oC) || empty($oD) || empty($oE) || empty($resposta)) {
        echo json_encode(["sucesso" => false, "mensagem" => "Erro: Preencha todos os campos do formulário."]);
        exit;
    }
    
    $comandoSQL=$conn->prepare("INSERT into pergunta_objetiva(id,pergunta,resposta_padrao,a,b,c,d,e) values (?,?,?,?,?,?,?,?)");

    if($comandoSQL)
        {
            $comandoSQL->bind_param("i  ",$id,$pergunta,$resposta,$oA,$oB,$oC,$oD,$oE);

            if($comandoSQL->execute())
                {
                     $conn->commit();
                    echo json_encode(["sucesso" => true, "mensagem" => "Pergunta objetiva salva com sucesso!"]);
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
   
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso negado. Use o formulário."]);
    exit;
}} catch (Exception $e) {
    
    echo json_encode([
        "sucesso" => false, 
        "mensagem" => "ERRO FATAL NO BANCO: " . $e->getMessage()
    ]);
    exit;
}
?>