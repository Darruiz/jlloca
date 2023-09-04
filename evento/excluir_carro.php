<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: /jlloca/login/login.php');
    exit();
}

require_once('conexao.php');

$database = new Database();
$db = $database->conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['car_id'])) {
        $carId = $_POST['car_id'];

        $query = "DELETE FROM carros WHERE id = :car_id";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':car_id', $carId, PDO::PARAM_INT);

        if ($stmt->execute()) {
            echo json_encode(array('message' => 'Carro excluído com sucesso.'));
        } else {
            echo json_encode(array('message' => 'Erro ao excluir o carro.'));
        }
    }
}
?>
