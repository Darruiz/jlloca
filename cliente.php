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
    <link rel="stylesheet" href="css/cliente.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-pzjw4bYQqtkp6F5EBcCBF5F7X5i5b/Af4IYLRypy5O2Z+8lL+T0N5uWq5cBsN5cBs" crossorigin="anonymous">
    <title>Clientes</title>
</head>
<body>

<div class="main">
<a href="novocliente.php" class="add-car-button">Adicionar Novo Cliente</a>
<a href="index.php" class="menu-button">
     Menu
</a>
<div class="car-details">
    <h3>Detalhes dos Clientes:</h3>
   

    <div class="car-list">
    <?php
    $query = "SELECT id, nome, rg, cnh, tipo_cnh, telefone, email, endereco FROM clientes"; 
    $stmt = $db->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $cliente_id = $row['id'];
        $tipo_cnh = explode(',', $row['tipo_cnh']);
        
        echo "<div class='car-item' data-id='{$cliente_id}'>";
        echo '<form action="evento/editar_cliente.php" method="POST">';
        echo"ID: {$cliente_id}";
        echo "<input type='hidden' name='cliente_id' value='{$cliente_id}'>";
        
        echo "<label for='nome{$cliente_id}' class='input-label'>Nome:</label>";
        echo "<input type='text' name='nome' id='nome{$cliente_id}' class='input-field' value='{$row['nome']}'>";
        
        echo "<label for='rg{$cliente_id}' class='input-label'>RG:</label>";
        echo "<input type='text' name='rg' id='rg{$cliente_id}' class='input-field' value='{$row['rg']}'>";
        
        echo "<label for='cnh{$cliente_id}' class='input-label'>CNH:</label>";
        echo "<input type='text' name='cnh' id='cnh{$cliente_id}' class='input-field' value='{$row['cnh']}'>";
        
        echo "<label class='input-label'>Tipo CNH:</label>";
        echo "<div class='checkbox-group'>";
        
        $opcoes_cnh = ["A", "B", "C", "D", "E"];
        
        foreach ($opcoes_cnh as $opcao) {
            $checked = in_array($opcao, $tipo_cnh) ? "checked" : ""; 
            echo "<input type='checkbox' name='tipo_cnh[]' id='{$opcao}{$cliente_id}' value='{$opcao}' {$checked}>";
            echo "<label for='{$opcao}{$cliente_id}' class='checkbox-label'>{$opcao}</label>";
        }
        
        echo "</div>"; 
        
        echo "<label for='telefone{$cliente_id}' class='input-label'>Telefone:</label>";
        echo "<input type='text' name='telefone' id='telefone{$cliente_id}' class='input-field' value='{$row['telefone']}'>";
        
        echo "<label for='email{$cliente_id}' class='input-label'>Email:</label>";
        echo "<input type='text' name='email' id='email{$cliente_id}' class='input-field' value='{$row['email']}'>";
        
        echo "<label for='endereco{$cliente_id}' class='input-label'>Endereço:</label>";
        echo "<input type='text' name='endereco' id='endereco{$cliente_id}' class='input-field' value='{$row['endereco']}'>";
        
        echo '<button class="edit-button" type="button">Editar</button>';
        echo '<button class="save-button" type="submit" style="display: none;">Salvar</button>';
        echo '</form>';
        
        echo '<form action="evento/excluir_cliente.php" method="POST">';
        echo "<input type='hidden' name='cliente_id' value='{$cliente_id}'>";
        echo '<button class="delete-button" type="submit">Excluir</button>';
        echo '</form>';
        
        echo "</div>";
    }
    
    ?>
</div>

</div>

<div class="car-details-right">
    <h3>Detalhes do Cliente</h3>
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

    editButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            button.style.display = "none";
            saveButtons[index].style.display = "inline";

          
            const inputs = document.querySelectorAll(`[data-id='${index}'] input`);
            inputs.forEach((input) => {
                input.removeAttribute("readOnly");
            });
        });
    });

    saveButtons.forEach((button, index) => {
        button.addEventListener("click", () => {
            button.style.display = "none";
            editButtons[index].style.display = "inline";

   
            const inputs = document.querySelectorAll(`[data-id='${index}'] input`);
            inputs.forEach((input) => {
                input.setAttribute("readOnly", true);
            });
        });
    });
});

</script>

</body>
</html>
