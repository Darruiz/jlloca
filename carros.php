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
    <h3>Detalhes do Carro</h3>
    <div class="car-list">
    <?php
    $query = "SELECT id, marca, modelo, ano, placa FROM carros"; 
    $stmt = $db->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<div class='car-item' data-id='{$row['id']}'>"; // Defina o atributo 'data-id'
        echo "<p>ID: {$row['id']}</p>";
        echo "<p><strong>Marca:</strong> " . $row['marca'] . "</p>";
        echo "<p><strong>Modelo:</strong> " . $row['modelo'] . "</p>";
        echo "<p><strong>Ano:</strong> " . $row['ano'] . "</p>";
        echo "<p><strong>Placa:</strong> " . $row['placa'] . "</p>";
        echo "<button class='delete-button' data-id='{$row['id']}'>Excluir</button>"; // Adicione o data-id aqui
        echo "</div>";
    }
    ?>
</div>

</div>

<div class="car-details-right">
    <h3>Detalhes do Carro</h3>
    <div class="car-details-content">
        <!-- Os detalhes do carro serão exibidos aqui -->
        
    </div>
    <button class="close-button">Fechar</button>
</div>


</div>
  
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>
<script>
var carDetails = document.querySelectorAll('.car-item');
var carDetailsRight = document.querySelector('.car-details-right');
var carDetailsContent = document.querySelector('.car-details-content');
var closeButton = document.querySelector('.close-button');

carDetails.forEach(function (carSquare) {
    carSquare.addEventListener('click', function () {
        var carId = carSquare.getAttribute('data-id'); // Obtenha o ID do atributo 'data-id'
        carDetailsContent.textContent = 'ID do Carro: ' + carId;
        carDetailsRight.style.display = 'block';
    });
});

closeButton.addEventListener('click', function () {
    carDetailsRight.style.display = 'none';
});

var deleteButtons = document.querySelectorAll('.delete-button');

deleteButtons.forEach(function (deleteButton) {
    deleteButton.addEventListener('click', function () {
        var carId = this.getAttribute('data-id'); // Obtenha o ID do carro a ser excluído
        
        if (confirm('Tem certeza de que deseja excluir este carro?')) {
            fetch('evento/excluir_carro.php', {
                method: 'POST',
                body: JSON.stringify({ car_id: carId }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.message === 'Carro excluído com sucesso.') {
                    alert('Carro excluído com sucesso.');
                    // Você pode adicionar código aqui para atualizar a lista de carros ou tomar outras ações necessárias
                } else {
                    alert('Erro ao excluir o carro.');
                }
            })
            .catch(error => {
                console.error('Erro na solicitação AJAX:', error);
            });
        }
    });
});
</script>
</body>
</html>
