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
    <link rel="stylesheet" href="css/alugueis.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-pzjw4bYQqtkp6F5EBcCBF5F7X5i5b/Af4IYLRypy5O2Z+8lL+T0N5uWq5cBsN5cBs" crossorigin="anonymous">
    <title>Carros</title>
</head>
<body>

<div class="main">
<a href="novaloca.php" class="add-car-button">Criar Locação</a>
<a href="index.php" class="menu-button">
     Menu
</a>
<div class="car-details"> 
<h3>Alugueis:</h3>
    <div class= "car-list">
        <?php 
        $query = "SELECT id, carro_alugado_id, valor_mensal_aluguel, data_inicial, valor_caucao FROM alugueis";
        $stmt = $db->prepare($query); 
        $stmt->execute(); 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { 
            $aluguel_id = $row['id']; 
            echo "<div class='car-item' data-id='{$aluguel_id}>'";
            echo "<form action='#' method = 'POST'> "; 
            echo "<input type='hidden' name = 'carro_alugado_id' value='{carro_alugado_id}'>";
            echo "<p>ID: {$carro_alugado_id<\p>";
        }
        ?> 

    </div>
</div>

</div>
  
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const editButtons = document.querySelectorAll(".edit-button");
        const saveButtons = document.querySelectorAll(".save-button");
        const valorInputs = document.querySelectorAll(".edit-valor");
        const renavamInputs = document.querySelectorAll(".edit-renavam");
        const quilometragemInputs = document.querySelectorAll(".edit-quilometragem");

        editButtons.forEach((button, index) => {
            button.addEventListener("click", () => {
            
                button.style.display = "none";
                saveButtons[index].style.display = "inline";

           
                valorInputs[index].readOnly = false;
                renavamInputs[index].readOnly = false;
                quilometragemInputs[index].readOnly = false;
            });
        });

        saveButtons.forEach((button, index) => {
            button.addEventListener("click", () => {
                
                button.style.display = "none";
                editButtons[index].style.display = "inline";

              
                valorInputs[index].readOnly = true;
                renavamInputs[index].readOnly = true;
                quilometragemInputs[index].readOnly = true;

                
            });
        });
    });
</script>

</body>
</html>
