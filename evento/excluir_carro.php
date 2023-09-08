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
    if (isset($_POST['car_id'])) {
        $carId = $_POST['car_id'];

     
        if ($db) {
            $query = "DELETE FROM carros WHERE id = :carId";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':carId', $carId, PDO::PARAM_INT);

            try {
                if ($stmt->execute()) {
               
                    header('Location: /jlloca/carros.php');
                    exit();
                } else {
                    echo 'Erro ao excluir o carro.';
                }
            } catch (PDOException $e) {
                echo 'Erro no banco de dados: ' . $e->getMessage();
            }
        } else {
            echo 'Erro na conexão com o banco de dados.';
        }
    } else {
        echo 'ID do carro não fornecido.';
    }
} else {
    echo 'Método de solicitação inválido.';
}
?>
