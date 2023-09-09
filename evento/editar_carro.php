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

if (isset($_POST['car_id'])) {
    $car_id = $_POST['car_id'];

    if (isset($_POST['valor'], $_POST['renavam'], $_POST['quilometragem'])) {
        $valor = $_POST['valor'];
        $renavam = $_POST['renavam'];
        $quilometragem = $_POST['quilometragem'];


        $query = "UPDATE carros SET valor = :valor, renavam = :renavam, quilometragem = :quilometragem WHERE id = :car_id";
        $stmt = $db->prepare($query);

        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':renavam', $renavam);
        $stmt->bindParam(':quilometragem', $quilometragem);
        $stmt->bindParam(':car_id', $car_id);

        if ($stmt->execute()) {
            header("Location: /jlloca/carros.php");
            exit();
        } else {
            echo "Erro ao atualizar os detalhes do carro.";
        }
    }
}

header("Location: /jlloca/carros.php");
exit();
?>
