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
    <link rel="stylesheet" href="css/novocarro.css">
    <script src="js/real.js"></script> 
    <script src="js/km.js"></script>
    <title>Novo carro</title>
</head>
<body>
<div class="header">
    <a class="nav-link" href="index.php">Menu</a> |
    <a class="nav-link" href="carros.php">Voltar</a>
</div>

<div class="main">
<form action="processar_cadastro_carro.php" method="post" class="car-form">
    <h2>Cadastro de Novo Carro</h2>
    <div class="form-group">
    <label for="marca">Marca do Veículo:</label>
    <select name="marca" id="marca" required>
        <option value="Toyota">Toyota</option>
        <option value="Honda">Honda</option>
        <option value="Volkswagen">Volkswagen</option>
        <option value="Ford">Ford</option>
        <option value="Chevrolet">Chevrolet</option>
        <option value="Fiat">Fiat</option>
        <option value="Renault">Renault</option>
    </select>
</div>

    <div class="form-group">
        <label for="modelo">Modelo:</label>
        <input type="text" name="modelo" id="modelo" required>
    </div>
    <div class="form-group">
        <label for="placa">Placa:</label>
        <input type="text" name="placa" id="placa" required>
    </div>
    <div class="form-group">
        <label for="renavam">Renavam:</label>
        <input type="text" name="renavam" id="renavam" required>
    </div>
    <div class="form-group">
        <label for="ano">Ano de Fabricação:</label>
        <input type="text" name="ano" id="ano" required>
    </div>
    <div class="form-group">
    <label for="valor">Valor de Mercado Aproximado:</label>
    <input type="text" name="valor" id="valor" oninput="formatCurrency(this)" pattern="[0-9]+([\.,][0-9]+)?" title="Digite um valor numérico" required>
    </div>
    <div class="form-group">
        <label for="cor">Cor:</label>
        <select name="cor" id="cor" required>
            <option value="#000000">Preto</option>
            <option value="#ffffff">Branco</option>
            <option value="#adadad">Prata</option> 
            <option value="#696969">Cinza</option> 
            <option value="#ff0000">Vermelho</option>
        </select>
    </div>
    <div class="form-group">
    <label for="km">Quilometragem (em km):</label>
    <input type="text" name="km" id="km" onblur="formatKilometers(this)" required>
    </div>

    <button type="submit" class="submit-button">Cadastrar Carro</button>
</form>

</div>
  
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>
</body>
</html>
