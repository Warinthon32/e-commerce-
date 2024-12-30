<?php
session_start();
require('fpdf/fpdf.php');
include 'condb.php';

// Check if order_id exists in session
if (!isset($_SESSION["order_id"])) {
    die("Error: Missing order ID in session.");
}

$orderID = $_SESSION["order_id"];

// Fetch order information
$sql = "SELECT * FROM tb_order WHERE orderID='$orderID'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching order: " . mysqli_error($conn));
}

$rs = mysqli_fetch_array($result);

if (!$rs) {
    die("Error: Order not found.");
}

// Create PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->Cell(0, 10, 'Order Receipt', 0, 1, 'C');
$pdf->Ln(10);

// Order details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Order ID: ' . $rs['orderID'], 0, 1);
$pdf->Cell(0, 10, 'Customer Name: ' . $rs['cus_name'], 0, 1);
$pdf->Cell(0, 10, 'Address: ' . $rs['adds'], 0, 1);
$pdf->Cell(0, 10, 'Phone Number: ' . $rs['phone_number'], 0, 1);
$pdf->Ln(10);

// Product table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(30, 10, 'Product ID', 1);
$pdf->Cell(80, 10, 'Product Name', 1);
$pdf->Cell(30, 10, 'Price', 1, 0, 'R');
$pdf->Cell(20, 10, 'Qty', 1, 0, 'R');
$pdf->Cell(30, 10, 'Total', 1, 0, 'R');
$pdf->Ln();

// Fetch order details
$sql1 = "SELECT * FROM order_detail d, products p WHERE d.pro_id=p.pro_id AND d.orderID='$orderID'";
$result1 = mysqli_query($conn, $sql1);

if (!$result1) {
    die("Error fetching order details: " . mysqli_error($conn));
}

$pdf->SetFont('Arial', '', 12);

while ($row = mysqli_fetch_array($result1)) {
    $pdf->Cell(30, 10, $row['pro_id'], 1);
    $pdf->Cell(80, 10, $row['pro_name'], 1);
    $pdf->Cell(30, 10, number_format($row['order_price'], 2), 1, 0, 'R');
    $pdf->Cell(20, 10, $row['orderQty'], 1, 0, 'R');
    $pdf->Cell(30, 10, number_format($row['total'], 2), 1, 0, 'R');
    $pdf->Ln();
}

// Total amount
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(160, 10, 'Total Amount', 1);
$pdf->Cell(30, 10, number_format($rs['total_price'], 2), 1, 0, 'R');
$pdf->Ln(10);

// Footer
$pdf->SetFont('Arial', 'I', 10);
$pdf->Cell(0, 10, 'Please transfer the payment within 7 days to Kasikorn Bank, Account No: 1212312120, Name: Miss Christina Saetae.', 0, 1, 'C');

// Output PDF in browser
$pdf->Output('I', 'Order_' . $orderID . '.pdf'); // 'I' = Inline
?>
