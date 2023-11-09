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
    <title>Nova Entrada</title>
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
        <label for='valor_entrada'>Valor da Entrada (em R$):</label>
        <input type='text' name='valor_entrada' id='valor_entrada' required>
    </div>
    <div class='form-group'>
        <label for='data_entrada'>Data da Entrada:</label>
        <input type='date' name='data_entrada' id='data_entrada' required>
    </div>
    <div class='form-group'>
        <label for='motivo_entrada'>Motivo da Entrada:</label>
        <input type='text' name='motivo_entrada' id='motivo_entrada' required>
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
    $valorEntrada = $_POST['valor_entrada'];
    $dataEntrada = $_POST['data_entrada'];
    $motivoEntrada = $_POST['motivo_entrada'];
    $descricao = $_POST['descricao'];
    $metodoPagamento = $_POST['metodo_pagamento'];

    $query = "INSERT INTO entrada (carro_id, cliente_id, valor_entrada, data_entrada, motivo_entrada, descricao, metodo_pagamento) 
              VALUES (:carroId, :clienteId, :valorEntrada, :dataEntrada, :motivoEntrada, :descricao, :metodoPagamento)";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':carroId', $carroId, PDO::PARAM_INT);
    $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);
    $stmt->bindParam(':valorEntrada', $valorEntrada, PDO::PARAM_STR);
    $stmt->bindParam(':dataEntrada', $dataEntrada, PDO::PARAM_STR);
    $stmt->bindParam(':motivoEntrada', $motivoEntrada, PDO::PARAM_STR);
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
    $stmt->bindParam(':metodoPagamento', $metodoPagamento, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            // Dados armazenados com sucesso
            header('Location: adicionar_entrada.php');
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
  