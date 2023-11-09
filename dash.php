<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login/login.php');
    exit();
}

require_once('evento/conexao.php');
date_default_timezone_set('America/Sao_Paulo');

$database = new Database();
$db = $database->conectar();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/dash.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-pzjw4bYQqtkp6F5EBcCBF5F7X5i5b/Af4IYLRypy5O2Z+8lL+T0N5uWq5cBsN5cBs" crossorigin="anonymous">
    <title>Carros</title>
</head>

<body>

    <div class="main">
        <a href="index.php" class="menu-button">
            Menu
        </a>

        <div class="main-grey">
                <div class="main-text-grey">
                    <h1 class="text-v">Patrimônio em Veículos:</h1>
                </div>
        </div>
        <div class="main-grey2">
        <div class="main-text-grey">
                    <h1 class="text-v">Caixa:</h1>
                </div>
                

        </div>

        <div class="large">

            <div class="large-c-1">
            <div class="main-text-grey">
                    <h1 class="text-v">Entrada:</h1>
                </div>
             <?php
require_once('evento/conexao.php');
$database = new Database();
$db = $database->conectar();

$query = "SELECT SUM(valor_entrada) AS total_entradas FROM entrada";
$stmt = $db->prepare($query);

try {
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalEntradas = $result['total_entradas'];
            echo "<h1 class='text-v mmm'>R$ " . number_format($totalEntradas, 2, ',', '.') . "</h1>";   
 } else {
        echo 'Erro ao buscar o valor total das entradas.';
    }
} catch (PDOException $e) {
    echo 'Erro no banco de dados: ' . $e->getMessage();
}
?>
            </div>

            <div class="large-c-2">
            <div class="main-text-grey">
                    <h1 class="text-r">Saída:</h1>
                </div>
                <?php
require_once('evento/conexao.php');
$database = new Database();
$db = $database->conectar();

$query = "SELECT SUM(valor_saida) AS total_saida FROM saida";
$stmt = $db->prepare($query);

try {
    if ($stmt->execute()) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalEntradas = $result['total_saida'];
            echo "<h1 class='text-r mmm'>R$ " . number_format($totalEntradas, 2, ',', '.') . "</h1>";   
 } else {
        echo 'Erro ao buscar o valor total das saida.';
    }
} catch (PDOException $e) {
    echo 'Erro no banco de dados: ' . $e->getMessage();
}
?>
            </div>

            <div class="large-c-2">
            <div class="main-text-grey">
                    <h1 class="text-lu">Lucro Bruto:</h1>
                </div>
            </div>

        </div>


        <div class="but-r">
            <a href="#" class="but-v">Ver Entradas</a>
            <a href="#" class="but-red">Ver Saidas</a>
            <a href="#" class="but-lu">Ver Lucros</a>

        </div>

        <div class="but-l">
        <a href="evento/adicionar_entrada.php" class="but-v">Adicionar Entradas</a>
        <a href="evento/adicionar_saida.php" class="but-red">Adicionar Saidas</a>

        </div>



    </div>
</body>

</html>