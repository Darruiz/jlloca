<?php 

session_start(); 

if (!isset($_SESSION['id'])) {
    header('Location: login/login.php');
    exit(); 
}

require_once('evento/conexao.php');
date_default_timezone_set('America/Sao_Paulo');

$database = new Database();
$db = $database->conectar();

$queryCarros = "SELECT id, placa FROM carros";
$resultCarros = $db->query($queryCarros);


$queryClientes = "SELECT id, nome FROM clientes";
$resultClientes = $db->query($queryClientes); 


$queryCarros = "SELECT id, placa, marca, modelo, valor, quilometragem FROM carros";
$resultCarros = $db->query($queryCarros);


$queryClientes = "SELECT id, nome, telefone FROM clientes";
$resultClientes = $db->query($queryClientes);   


$queryAlugueis = "SELECT id, carro_id, cliente_id, valor_mensal, data_inicial, valor_caucao FROM locacoes"; 
$resultAlugueis = $db->query($queryAlugueis);

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dash.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>