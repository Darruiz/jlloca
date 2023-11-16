<?php
session_start();
if (!isset($_SESSION['id'])) {
    header('Location: ../login/login.php');
    exit;
}
require_once('../evento/conexao.php');
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
if (isset($_GET['export'])) {
    require '../vendor/autoload.php';
    require '../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Spreadsheet.php';
    require '../vendor/phpoffice/phpspreadsheet/src/PhpSpreadsheet/Writer/Xlsx.php';
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
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
    foreach ($entradas as $entrada) {
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
    $filePath = '../planilhas/entradas_geradas/entradas.xlsx';
    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $writer->save($filePath);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="entradas.xlsx"');
    readfile($filePath);
    exit;
}
?>