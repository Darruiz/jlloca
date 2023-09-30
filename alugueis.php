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
    <title>Alugueis</title>
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
    $query = "SELECT l.id, l.carro_id, l.valor_mensal, l.data_inicial, l.valor_caucao, c.modelo, c.placa, cl.nome AS cliente_nome 
            FROM locacoes AS l
            JOIN carros AS c ON l.carro_id = c.id
            JOIN clientes AS cl ON l.cliente_id = cl.id";
    $stmt = $db->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $aluguel_id = $row['id'];
        echo "<div class='car-item' data-id='{$aluguel_id}'>";
        
        echo "<p>ID do Aluguel: {$aluguel_id}</p>";
      
        echo "<form action='evento/editar_aluguel.php' method='POST'>";
        echo "<input type='hidden' name='aluguel_id' value='{$aluguel_id}'>";
        echo "<div class='input-field'>";
        echo "<label for='modelo_placa'>Modelo e Placa:</label>";
        echo "<input type='text' name='modelo_placa' id='modelo_placa' class='styled-input' value='{$row['modelo']} {$row['placa']}' readonly>";
        echo "</div>";
        echo "<div class='input-field'>";
        echo "<label for='cliente_nome'>Nome do Cliente:</label>";
        echo "<input type='text' name='cliente_nome' id='cliente_nome' class='styled-input' value='{$row['cliente_nome']}' readonly>";
        echo "</div>";
    
        echo "<div class='input-field'>";
        echo "<label for='valor_mensal'>Valor Mensal:</label>";
        echo "<input type='text' name='valor_mensal' id='valor_mensal' class='styled-input edit-valor' value='{$row['valor_mensal']}' >";
        echo "</div>";
        echo "<div class='input-field'>";
        echo "<label for='data_inicial'>Data Inicial:</label>";
        echo "<input type='text' name='data_inicial' id='data_inicial' class='styled-input' value='{$row['data_inicial']}' >";
        echo "</div>";
        echo "<div class='input-field'>";
        echo "<label for='valor_caucao'>Valor Caução:</label>";
        echo "<input type='text' name='valor_caucao' id='valor_caucao' class='styled-input' value='{$row['valor_caucao']}' >";
        echo "</div>";
        echo '<button class="edit-button">Editar</button>';
        echo '<button class="save-button" style="display:none;">Salvar</button>';
        echo '</form>';
        
        // Botão de exclusão dentro do mesmo "div" do formulário
        echo '<form action="evento/excluir_aluguel.php" method="POST">';
        echo "<input type='hidden' name='aluguel_id' value='{$aluguel_id}'>";
        echo '<button class="delete-button" type="submit">Excluir</button>';
        echo '</form>';
        
        echo "</div>";
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
        const inputsToEdit = document.querySelectorAll(".styled-input.edit-valor");

        editButtons.forEach((button, index) => {
            button.addEventListener("click", () => {
                button.style.display = "none";
                saveButtons[index].style.display = "inline";
                inputsToEdit[index].readOnly = false;
            });
        });

        saveButtons.forEach((button, index) => {
            button.addEventListener("click", () => {
                button.style.display = "none";
                editButtons[index].style.display = "inline";
                inputsToEdit[index].readOnly = true;
            });
        });
    });
</script>

</body>
</html>
