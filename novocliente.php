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
    <link rel="stylesheet" href="css/novocliente.css">
 
    <title>Novo carro</title>
</head>
<body>
<div class="header">
    <a class="nav-link" href="index.php">Menu</a> |
    <a class="nav-link" href="cliente.php">Voltar</a>
</div>

<div class="main">
<form action="evento/processar_cadastro_cliente.php" method="post" class="car-form">
    <h2>Cadastro de Novo Cliente</h2>
    <div class="form-group">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" required>
    </div>
    <div class="form-group">
        <label for="rg">RG:</label>
        <input type="text" name="rg" id="rg" required>
    </div>
    <div class="form-group">
        <label for="cnh">Número CNH:</label>
        <input type="text" name="cnh" id="cnh" required>
    </div>
    <label>Tipo de CNH:</label>
<div class="checkbox-group">
    <input type="checkbox" name="tipo_cnh[]" id="a" value="A">
    <label for="a">A</label>

    <input type="checkbox" name="tipo_cnh[]" id="b" value="B">
    <label for="b">B</label>

    <input type="checkbox" name="tipo_cnh[]" id="c" value="C">
    <label for="c">C</label>

    <input type="checkbox" name="tipo_cnh[]" id="d" value="D">
    <label for="d">D</label>

    <input type="checkbox" name="tipo_cnh[]" id="e" value="E">
    <label for="e">E</label>
</div>

    <div class="form-group">
        <label for="endereco">Endereço completo:</label>
        <input type="text" name="endereco" id="endereco" required>
    </div>
    <div class="form-group">
        <label for="telefone">Telefone:</label>
        <input type="tel" name="telefone" id="telefone" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
    </div>

    <button type="submit" class="submit-button">Cadastrar Cliente</button>
</form>

</div>
  
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>
</body>
</html>
