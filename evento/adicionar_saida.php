<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login/login.php');
    exit();
}
require_once('../evento/conexao.php');
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
    <link rel="stylesheet" href="../css/novaloca.css">
    <title>Nova saida</title>
</head>
<body>
<div class="header">
    <a class="nav-link" href="../">Menu</a> |
    <a class="nav-link" href="../dash.php">Voltar</a>
</div>
<div class="main">
    <?php
    $queryCarros = "SELECT id, placa, modelo FROM carros";
    $stmtCarros = $db->prepare($queryCarros);
    $stmtCarros->execute();
    $queryClientes = "SELECT id, nome FROM clientes";
    $stmtClientes = $db->prepare($queryClientes);
    $stmtClientes->execute();
    ?>
    <form action='' method='post'>
    <div class='form-group'>
        <label for='carro'>Placa:</label>
        <select name='carro' id='carro' required>
            <?php
            while ($row = $stmtCarros->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['placa']} {$row['modelo']} </option>";
            }
            ?>
        </select>
    </div>
    <div class='form-group'>
        <label for='cliente'>Cliente:</label>
        <select name='cliente' id='cliente' required>
            <?php
            while ($row = $stmtClientes->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='{$row['id']}'>{$row['nome']}</option>";
            }
            ?>
        </select>
    </div>
    <div class='form-group'>
        <label for='valor_saida'>Valor da Saída (em R$):</label>
        <input type='text' name='valor_saida' id='valor_saida' required>
    </div>
    <div class='form-group'>
        <label for='data_saida'>Data da Saída:</label>
        <input type='date' name='data_saida' id='data_saida' required>
    </div>
    <div class='form-group'>
        <label for='motivo_saida'>Motivo da Saída:</label>
        <input type='text' name='motivo_saida' id='motivo_saida' required>
    </div>
    <div class='form-group'>
        <label for='descricao'>Descrição:</label>
        <textarea name='descricao' id='descricao' rows='4' cols='50'></textarea>
    </div>
    <div class='form-group'>
        <label for='metodo_pagamento'>Método de Pagamento:</label>
        <select name='metodo_pagamento' id='metodo_pagamento' required>
            <option value='PIX'>PIX</option>
            <option value='Boleto'>Boleto</option>
            <option value='Cartão'>Cartão</option>
            <option value='Dinheiro'>Dinheiro</option>
        </select>
    </div>
    <input type='submit' value='Enviar'>
</form>
  
</div>
<div class="container">
    <footer>&copy; Darruiz 2023</footer>
</div>

<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login/login.php');
    exit();
}
require_once('../evento/conexao.php');
date_default_timezone_set('America/Sao_Paulo');
$database = new Database();
$db = $database->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carroId = $_POST['carro'];
    $clienteId = $_POST['cliente'];
    $valorSaida = -$_POST['valor_saida']; // Armazena o valor da saída como negativo
    $dataSaida = $_POST['data_saida'];
    $motivoSaida = $_POST['motivo_saida'];
    $descricao = $_POST['descricao'];
    $metodoPagamento = $_POST['metodo_pagamento'];

    $query = "INSERT INTO saida (carro_id, cliente_id, valor_saida, data_saida, motivo_saida, descricao, metodo_pagamento) 
              VALUES (:carroId, :clienteId, :valorSaida, :dataSaida, :motivoSaida, :descricao, :metodoPagamento)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':carroId', $carroId, PDO::PARAM_INT);
    $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmt->bindParam(':valorSaida', $valorSaida, PDO::PARAM_STR);
    $stmt->bindParam(':dataSaida', $dataSaida, PDO::PARAM_STR);
    $stmt->bindParam(':motivoSaida', $motivoSaida, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':metodoPagamento', $metodoPagamento, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            // Dados armazenados com sucesso
            header('Location: adicionar_saida.php');
            exit();
        } else {
            echo 'Erro ao armazenar os dados no banco de dados.';
        }
    } catch (PDOException $e) {
        echo 'Erro no banco de dados: ' . $e->getMessage();
    }
}
?>
</body>
</html>
  