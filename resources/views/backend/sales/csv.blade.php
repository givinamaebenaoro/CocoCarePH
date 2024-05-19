<?php
$now = gmdate("D, d M Y H:i:s");
header('Content-Type: text/csv; charset=utf-8');
$filename = "SALESREPORT_" . date("Ymd") . ".csv"; // Changed file name to include date
header('Content-Disposition: attachment; filename="' . $filename . '"');
$output = fopen("php://output", "w");

// Define bold style for headers
$boldStyle = 'font-weight:bold';

// Write year and month in the left corner
fputcsv($output, array('Year:', date('Y')), ',', ' ', $boldStyle);
fputcsv($output, array('Month:', date('F')), ',', ' ', $boldStyle);
fputcsv($output, array(), ',', ' ');

$headerRow = array('ID', 'Price', 'Payment Date');
fputcsv($output, $headerRow, ',', ' ', '<b>'); // Bold style applied to header row


$totalAmount = 0; // Initialize total amount variable

foreach ($orders as $order) {
    $formatted_date = date("Y-m-d H:i:s", strtotime($order->created_at)); // Format the date
    $dataRow = array($order->id, $order->total_amount, $formatted_date);
    fputcsv($output, $dataRow);
    $totalAmount += $order->total_amount; // Accumulate total amount
}

// Add total amount row to data
$totalRow = array('', 'Total Amount', $totalAmount);
fputcsv($output, $totalRow);

fclose($output);
exit();
?>
