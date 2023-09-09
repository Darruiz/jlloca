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
    $nome = $_POST['nome'];
    $rg = $_POST['rg'];
    $cnh = $_POST['cnh'];
    $telefones = $_POST['telefone'];
    $email = $_POST['email'];
    $endereco = $_POST['endereco'];
    $tipos_cnh = implode(', ', $_POST['tipo_cnh']); 
    $query = "INSERT INTO clientes (nome, rg, cnh, tipo_cnh, telefone, email, endereco) 
              VALUES (:nome, :rg, :cnh, :tipo_cnh, :telefones, :email, :endereco)";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':rg', $rg);
    $stmt->bindParam(':cnh', $cnh);
    $stmt->bindParam(':tipo_cnh', $tipos_cnh);
    $stmt->bindParam(':telefones', $telefones);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':endereco', $endereco);

    if ($stmt->execute()) {
        header('Location: /jlloca/cliente.php');
        exit();
    } else {
        echo "Erro ao cadastrar o cliente.";
    }
}
?>
