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
    <link rel="stylesheet" href="css/index.css">
    <title>Menu JL</title>
</head>
<body> 
<a href="logout.php" class="logout-button">Sair</a>

    <img src="imagens/fundoc1.png" alt="Imagem de fundo" id="background-image">
    <div class="main">
        <div class="square-row">
            <div class="square">
                <a href="carros.php">
                    <div class="square-content">
                        <img src="imagens/carros.png" alt="Ícone 1">
                        <h2>Carros</h2>
                    </div>
                </a>
            </div>
            <div class="square">
                <a href="pagina2.html">
                    <div class="square-content">
                        <img src="imagens/pessoa.png" alt="Ícone 2">
                        <h2>Clientes</h2>
                    </div>
                </a>
            </div>
            <div class="square">
                <a href="pagina3.html">
                    <div class="square-content">
                        <img src="icone3.png" alt="Ícone 3">
                        <h2>Título 3</h2>
                    </div>
                </a>
            </div>
        </div>
        <div class="square-row">
            <div class="square">
                <a href="pagina4.html">
                    <div class="square-content">
                        <img src="icone4.png" alt="Ícone 4">
                        <h2>Título 4</h2>
                    </div>
                </a>
            </div>
            <div class="square">
                <a href="pagina5.html">
                    <div class="square-content">
                        <img src="icone5.png" alt="Ícone 5">
                        <h2>Título 5</h2>
                    </div>
                </a>
            </div>
            <div class="square">
                <a href="pagina6.html">
                    <div class="square-content">
                        <img src="icone6.png" alt="Ícone 6">
                        <h2>Título 6</h2>
                    </div>
                </a>
            </div>
        </div>
    </div>






    <div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>
</body>
</html>
