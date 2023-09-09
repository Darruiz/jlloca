<?php
require_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['car_id'])) {
    $carId = $_GET['car_id'];

    $query = "SELECT * FROM carros WHERE id = :carId"; 
    $stmt = $db->prepare($query);
    $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $carro = $stmt->fetch(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($carro);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
?>
