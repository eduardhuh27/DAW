<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    echo json_encode([
        "logado" => true, 
        "nome" => $_SESSION['nome'] 
    ]);
} else {
    echo json_encode(["logado" => false]);
}
?>