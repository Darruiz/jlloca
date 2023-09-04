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
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/carros.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-pzjw4bYQqtkp6F5EBcCBF5F7X5i5b/Af4IYLRypy5O2Z+8lL+T0N5uWq5cBsN5cBs" crossorigin="anonymous">
    <title>Carros</title>
</head>
<body>

<div class="main">
<a href="novocarro.php" class="add-car-button">Adicionar Novo Carro</a>
<a href="index.php" class="menu-button">
     Menu
</a>


</div>
  
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>
</body>
</html>
