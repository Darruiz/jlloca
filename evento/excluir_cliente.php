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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cliente_id'])) {
        $clienteId = $_POST['cliente_id'];

        if ($db) {
            $query = "DELETE FROM clientes WHERE id = :clienteId";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':clienteId', $clienteId, PDO::PARAM_INT);

            try {
                if ($stmt->execute()) {
                    header('Location: /jlloca/cliente.php'); 
                    exit();
                } else {
                    echo 'Erro ao excluir o cliente.';
                }
            } catch (PDOException $e) {
                echo 'Erro no banco de dados: ' . $e->getMessage();
            }
        } else {
            echo 'Erro na conexão com o banco de dados.';
        }
    } else {
        echo 'ID do cliente não fornecido.';
    }
} else {
    echo 'Método de solicitação inválido.';
}
?>
