<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /jlloca/login/login.php');
    exit();
}

require_once('conexao.php');
date_default_timezone_set('America/Sao_Paulo');

$database = new Database();
$db = $database->conectar();

if (isset($_POST['cliente_id'])) {
    $cliente_id = $_POST['cliente_id'];

    if (isset($_POST['nome'], $_POST['rg'], $_POST['cnh'], $_POST['endereco'], $_POST['telefone'], $_POST['email'])) {
        $nome = $_POST['nome'];
        $rg = $_POST['rg'];
        $cnh = $_POST['cnh'];
        $endereco = $_POST['endereco'];
        $telefone = $_POST['telefone'];
        $email = $_POST['email'];

       
        if (isset($_POST['tipo_cnh']) && is_array($_POST['tipo_cnh'])) {
            $tipo_cnh = implode(',', $_POST['tipo_cnh']);
        } else {
            $tipo_cnh = ''; 
        }

        $query = "UPDATE clientes SET nome = :nome, rg = :rg, cnh = :cnh, tipo_cnh = :tipo_cnh, endereco = :endereco, telefone = :telefone, email = :email WHERE id = :cliente_id";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':rg', $rg);
        $stmt->bindParam(':cnh', $cnh);
        $stmt->bindParam(':tipo_cnh', $tipo_cnh);
        $stmt->bindParam(':endereco', $endereco);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':cliente_id', $cliente_id);

        if ($stmt->execute()) {
            header("Location: /jlloca/cliente.php");
            exit();
        } else {
            echo "Erro ao atualizar os detalhes do cliente.";
        }
    }
}

header("Location: /jlloca/cliente.php");
exit();
?>
