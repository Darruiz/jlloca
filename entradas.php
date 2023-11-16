<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: login/login.php');
    exit;
}

require_once('evento/conexao.php');
$database = new Database();
$db = $database->conectar();

$dataInicial = $_GET['data_inicial'] ?? '';
$dataFinal = $_GET['data_final'] ?? '';
$clienteId = $_GET['cliente_id'] ?? '';

$query = "SELECT e.id, c.placa, cl.nome AS cliente_nome, e.valor_entrada, e.data_entrada, e.motivo_entrada, e.descricao, e.metodo_pagamento 
          FROM entrada e
          INNER JOIN carros c ON e.carro_id = c.id
          INNER JOIN clientes cl ON e.cliente_id = cl.id
          WHERE (:data_inicial = '' OR e.data_entrada >= :data_inicial)
          AND (:data_final = '' OR e.data_entrada <= :data_final)
          AND (:cliente_id = '' OR e.cliente_id = :cliente_id)";
$stmt = $db->prepare($query);
$stmt->bindParam(':data_inicial', $dataInicial);
$stmt->bindParam(':data_final', $dataFinal);
$stmt->bindParam(':cliente_id', $clienteId);
$stmt->execute();
$entradas = $stmt->fetchAll(PDO::FETCH_ASSOC);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$filteredEntradas = array_filter($entradas, function ($entrada) use ($dataInicial, $dataFinal, $clienteId) {
    $dataInicialMatch = empty($dataInicial) || strtotime($entrada['data_entrada']) >= strtotime($dataInicial);
    $dataFinalMatch = empty($dataFinal) || strtotime($entrada['data_entrada']) <= strtotime($dataFinal);
    $clienteIdMatch = empty($clienteId) || $entrada['cliente_id'] == $clienteId;
    return $dataInicialMatch && $dataFinalMatch && $clienteIdMatch;
});
var_dump($filteredEntradas);
if (isset($_GET['export'])) { 
    require 'vendor/autoload.php';

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Data');
    $sheet->setCellValue('B1', 'Placa');
    $sheet->setCellValue('C1', 'Cliente');
    $sheet->setCellValue('D1', 'Valor da Entrada R$');
    $sheet->setCellValue('E1', 'Data da Entrada');
    $sheet->setCellValue('F1', 'Motivo da Entrada');
    $sheet->setCellValue('G1', 'Descrição');
    $sheet->setCellValue('H1', 'Método de Pagamento');
    $row = 2; 

    foreach ($filteredEntradas as $entrada) {
        $sheet->setCellValue('A' . $row, $entrada['data_entrada']);
        $sheet->setCellValue('B' . $row, $entrada['placa']);
        $sheet->setCellValue('C' . $row, $entrada['cliente_nome']);
        $sheet->setCellValue('D' . $row, $entrada['valor_entrada']);
        $sheet->setCellValue('E' . $row, $entrada['data_entrada']);
        $sheet->setCellValue('F' . $row, $entrada['motivo_entrada']);
        $sheet->setCellValue('G' . $row, $entrada['descricao']);
        $sheet->setCellValue('H' . $row, $entrada['metodo_pagamento']);
        $row++;
    }

    $writer = new Xlsx($spreadsheet);
    $filePath = 'planilhas/entradas_geradas/entradas.xlsx';
    $writer->save($filePath);

    header('Location: ' . $filePath);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/entradas.css"> 
    <title>Entradas Registradas</title>
</head>
<body>
    <div class="main">
        <a href="dash.php" class="menu-button">
            Voltar
        </a> 
        <div class="geral">
            <h2>Entradas Registradas</h2>
            <form action="" method="GET">
                <label for="data_inicial">Data Inicial:</label>
                <input type="date" id="data_inicial" name="data_inicial" value="<?php echo $dataInicial; ?>">
                <label for="data_final">Data Final:</label>
                <input type="date" id="data_final" name="data_final" value="<?php echo $dataFinal; ?>">
                <label for="cliente_id">Cliente:</label>
                <select id="cliente_id" name="cliente_id">
                    <option value="">Todos</option>
                    <?php
                    foreach ($clientes as $cliente) {
                        $selected = ($clienteId == $cliente['id']) ? 'selected' : '';
                        echo "<option value='".$cliente['id']."' ".$selected.">".$cliente['nome']."</option>";
                    }
                    ?>
                </select>
                <button type="submit">Filtrar</button>
            </form>
            <form action="" method="GET">
                <button type="submit" name="export">Converter para Excel</button>
            </form>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Placa</th>
                        <th>Cliente</th>
                        <th>Valor da Entrada R$</th>
                        <th>Data da Entrada</th>
                        <th>Motivo da Entrada</th>
                        <th>Descrição</th>
                        <th>Método de Pagamento</th>
                        <th>Ações</th> 
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($filteredEntradas as $entrada): ?>
                        <tr>
                            <td><?php echo $entrada['id']; ?></td>
                            <td><?php echo $entrada['placa']; ?></td>
                            <td><?php echo $entrada['cliente_nome']; ?></td>
                            <td><?php echo $entrada['valor_entrada']; ?></td>
                            <td><?php echo $entrada['data_entrada']; ?></td>
                            <td><?php echo $entrada['motivo_entrada']; ?></td>
                            <td class="descricao-cell"><?php echo nl2br($entrada['descricao']); ?></td>
                            <td><?php echo $entrada['metodo_pagamento'];?></td>
                            <td>
                                <a href="evento/excluir_entrada.php?id=<?php echo $entrada['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir a entrada?')">Excluir Entrada</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
