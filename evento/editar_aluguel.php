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

if (isset($_POST['aluguel_id'])) {
    $aluguel_id = $_POST['aluguel_id'];

    if (isset($_POST['valor_mensal'], $_POST['data_inicial'], $_POST['valor_caucao'])) {
        $valor_mensal = $_POST['valor_mensal'];
        $data_inicial = $_POST['data_inicial'];
        $valor_caucao = $_POST['valor_caucao'];

        try {
            $db->beginTransaction();

            $query = "UPDATE locacoes SET valor_mensal = :valor_mensal, data_inicial = :data_inicial, valor_caucao = :valor_caucao WHERE id = :aluguel_id";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':valor_mensal', $valor_mensal);
            $stmt->bindParam(':data_inicial', $data_inicial);
            $stmt->bindParam(':valor_caucao', $valor_caucao);
            $stmt->bindParam(':aluguel_id', $aluguel_id);

            if ($stmt->execute()) {
                $db->commit();
                header("Location: /jlloca/alugueis.php");
                exit();
            } else {
                $db->rollBack();
                echo "Erro ao atualizar os detalhes do aluguel.";
            }
        } catch (PDOException $e) {
            $db->rollBack();
            echo "Erro: " . $e->getMessage();
        }
    }
}

header("Location: /jlloca/alugueis.php");
exit();
?>
