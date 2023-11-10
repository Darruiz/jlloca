<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit;
}

require_once('conexao.php');
$database = new Database();
$db = $database->conectar();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM entrada WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header('Location: ../entradas.php');
        exit;
    } else {
        echo "Ocorreu um erro ao excluir a entrada.";
    }
} else {
    echo "ID da entrada não fornecido.";
}
?>