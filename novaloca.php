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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/novaloca.css">

    <title>Nova Locação</title>
</head>
<body>
<div class="header">
    <a class="nav-link" href="index.php">Menu</a> |
    <a class="nav-link" href="alugueis.php">Voltar</a>
</div>

<div class="main">
<?php

$queryCarros = "SELECT id, placa FROM carros"; 
$stmtCarros = $db->prepare($queryCarros);
$stmtCarros->execute();  

$queryClientes = "SELECT id, nome FROM clientes"; 
$stmtClientes = $db->prepare($queryClientes);
$stmtClientes->execute();

?>
<form action='evento/processar_cadastro_aluguel.php' method='post'>
    <div class='form-group'>
        <label for='carro'>Placa:</label>
        <select name='carro' id='carro' required>
            <?php
            while ($row = $stmtCarros->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['placa']}'>{$row['placa']}</option>";
            }
            ?>
        </select>
    </div>
    
    <div class='form-group'>
        <label for='cliente'>Cliente:</label>
        <select name='cliente' id='cliente' required>
            <?php
            while ($row = $stmtClientes->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['nome']}'>{$row['nome']}</option>";
            }
            ?>
        </select>
    </div>
    <div class='form-group'>
        <label for='valor_mensal'>Valor Mensal do Aluguel (em reais):</label>
        <input type='text' name='valor_mensal' id='valor_mensal' required>
    </div>

    <div class='form-group'>
        <label for='data_inicial'>Data de Início da Locação:</label>
        <input type='date' name='data_inicial' id='data_inicial' required>
    </div>

    <div class='form-group'>
        <label for='valor_caucao'>Valor do Caução (em reais):</label>
        <input type='text' name='valor_caucao' id='valor_caucao' required>
    </div>
    <input type='submit' value='Enviar'>
</form>


</div>
  
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>
</body>
</html>
