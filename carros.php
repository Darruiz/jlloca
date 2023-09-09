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
<div class="car-details">
    <h3>Detalhes dos Carros:</h3>
    <div class="car-list">
    <?php
        $query = "SELECT id, marca, modelo, ano, placa, valor, renavam, quilometragem FROM carros"; 
        $stmt = $db->prepare($query);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $car_id = $row['id'];
            echo "<div class='car-item' data-id='{$car_id}'>";
            echo '<form action="evento/editar_carro.php" method="POST">';
            echo "<input type='hidden' name='car_id' value='{$car_id}'>";
            echo "<p>ID: {$car_id}</p>";
            echo "<p><strong>Marca:</strong> <input type='text' name='marca' value='{$row['marca']}'></p>";
            echo "<p><strong>Modelo:</strong> <input type='text' name='modelo' value='{$row['modelo']}'></p>";
            echo "<p><strong>Ano:</strong> <input type='text' name='ano' value='{$row['ano']}'></p>";
            echo "<p><strong>Placa:</strong> <input type='text' name='placa' value='{$row['placa']}'></p>";
            echo "<p><strong>Valor:</strong> <input type='text' name='valor' value='{$row['valor']}'></p>";
            echo "<p><strong>Renavam:</strong> <input type='text' name='renavam' value='{$row['renavam']}'></p>";
            echo "<p><strong>Quilometragem:</strong> <input type='text' name='quilometragem' value='{$row['quilometragem']}'></p>";
            echo '<button class="edit-save-button" type="submit">Salvar</button>';
            echo '</form>';
            echo '<form action="evento/excluir_carro.php" method="POST">';
            echo "<input type='hidden' name='car_id' value='{$car_id}'>";
            echo '<button class="delete-button" type="submit">Excluir</button>';
            echo '</form>';
            echo "</div>";
            
        }
        ?>
</div>

</div>

<div class="car-details-right">
    <h3>Detalhes do Carro</h3>
    <div class="car-details-content">
      
        
    </div>
    <button class="close-button">Fechar</button>
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
