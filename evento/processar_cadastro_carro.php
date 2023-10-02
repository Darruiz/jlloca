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
    
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $placa = $_POST['placa'];
    $renavam = $_POST['renavam'];
    $ano = $_POST['ano'];

 
    $valor = preg_replace("/[^0-9]/", "", $_POST['valor']);
 
    $valor = floatval($valor) / 100.0;

    $quilometragem = preg_replace("/[^0-9]/", "", $_POST['km']);

    $cor = $_POST['cor'];

    $query = "INSERT INTO carros (marca, modelo, placa, renavam, ano, valor, cor, quilometragem) 
              VALUES (:marca, :modelo, :placa, :renavam, :ano, :valor, :cor, :quilometragem)";

    $stmt = $db->prepare($query);

    $stmt->bindParam(':marca', $marca);
    $stmt->bindParam(':modelo', $modelo);
    $stmt->bindParam(':placa', $placa);
    $stmt->bindParam(':renavam', $renavam);
    $stmt->bindParam(':ano', $ano);
    $stmt->bindParam(':valor', $valor);
    $stmt->bindParam(':cor', $cor);
    $stmt->bindParam(':quilometragem', $quilometragem);

    if ($stmt->execute()) {
        header('Location: /jlloca/carros.php');
        exit();
    } else {
        echo "Erro ao cadastrar o carro.";
    }
}

