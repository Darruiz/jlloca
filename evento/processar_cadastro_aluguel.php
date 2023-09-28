<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login/login.php');
    exit();
}

require_once('conexao.php');
date_default_timezone_set('America/Sao_Paulo');

$database = new Database();
$db = $database->conectar();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   
    $carroPlaca = $_POST['carro'];
    $clienteNome = $_POST['cliente'];
    $valorMensal = $_POST['valor_mensal'];
    $dataInicial = $_POST['data_inicial'];
    $valorCaucao = $_POST['valor_caucao'];

 
    $queryCarroId = "SELECT id FROM carros WHERE placa = :placa";
    $stmtCarroId = $db->prepare($queryCarroId);
    $stmtCarroId->bindParam(':placa', $carroPlaca);
    $stmtCarroId->execute();
    $carroId = $stmtCarroId->fetchColumn();

    $queryClienteId = "SELECT id FROM clientes WHERE nome = :nome";
    $stmtClienteId = $db->prepare($queryClienteId);
    $stmtClienteId->bindParam(':nome', $clienteNome);
    $stmtClienteId->execute();
    $clienteId = $stmtClienteId->fetchColumn();

   
    $queryInserirLocacao = "INSERT INTO locacoes (carro_id, cliente_id, valor_mensal, data_inicial, valor_caucao) VALUES (:carro_id, :cliente_id, :valor_mensal, :data_inicial, :valor_caucao)";
    $stmtInserirLocacao = $db->prepare($queryInserirLocacao);
    $stmtInserirLocacao->bindParam(':carro_id', $carroId);
    $stmtInserirLocacao->bindParam(':cliente_id', $clienteId);
    $stmtInserirLocacao->bindParam(':valor_mensal', $valorMensal);
    $stmtInserirLocacao->bindParam(':data_inicial', $dataInicial);
    $stmtInserirLocacao->bindParam(':valor_caucao', $valorCaucao);

    if ($stmtInserirLocacao->execute()) {
        echo "Locação registrada com sucesso!";
        header('Location:/jlloca/alugueis.php');
    } else {
        echo "Erro ao registrar a locação.";
    }
}
?>


