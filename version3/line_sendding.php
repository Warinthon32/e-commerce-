<?php
session_start();
require('fpdf.php');
include('condb.php');

$LINE_API_TOKEN = '7kpS3zZucInUuXYI1rX5KRNwNVuQw7kiVmwxICJL2Bz';

function sendLineNotifyWithFile($message, $filePath) {
    $url = 'https://notify-api.line.me/api/notify';
    $headers = array(
        'Content-Type: multipart/form-data',
        'Authorization: Bearer ' . $GLOBALS['LINE_API_TOKEN']
    );

    $postData = [
        'message' => $message,
        'imageFile' => new CURLFile($filePath)
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

if (isset($_SESSION['orderID'])) {
    $orderID = $_SESSION['orderID'];
    
    $query = "SELECT * FROM tb_order WHERE orderID = '$orderID'";
    $result = mysqli_query($condb, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $order = mysqli_fetch_assoc($result);

        $query_detail = "SELECT * FROM order_detail WHERE orderID = '$orderID'";
        $result_detail = mysqli_query($condb, $query_detail);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 12);
        
        $pdf->Cell(0, 10, 'Order ID: ' . $order['orderID'], 0, 1);
        $pdf->Cell(0, 10, 'Customer: ' . $order['customer_name'], 0, 1);
        $pdf->Cell(0, 10, 'Address: ' . $order['address'], 0, 1);
        $pdf->Cell(0, 10, 'Phone: ' . $order['phone'], 0, 1);
        
        $pdf->Ln(10);
        $pdf->Cell(50, 10, 'Product Name', 1);
        $pdf->Cell(30, 10, 'Price', 1);
        $pdf->Cell(30, 10, 'Quantity', 1);
        $pdf->Cell(30, 10, 'Total', 1);
        $pdf->Ln();
        
        $totalAmount = 0;
        while ($detail = mysqli_fetch_assoc($result_detail)) {
            $productID = $detail['productID'];
            $query_product = "SELECT * FROM products WHERE productID = '$productID'";
            $result_product = mysqli_query($condb, $query_product);
            $product = mysqli_fetch_assoc($result_product);
            
            $total = $detail['quantity'] * $product['price'];
            $totalAmount += $total;

            $pdf->Cell(50, 10, $product['product_name'], 1);
            $pdf->Cell(30, 10, number_format($product['price'], 2), 1);
            $pdf->Cell(30, 10, $detail['quantity'], 1);
            $pdf->Cell(30, 10, number_format($total, 2), 1);
            $pdf->Ln();
        }

        $pdf->Cell(110, 10, 'Total Amount', 1);
        $pdf->Cell(30, 10, number_format($totalAmount, 2), 1);
        
        $pdfFilePath = 'path/to/save/Order_' . $orderID . '.pdf';
        $pdf->Output('F', $pdfFilePath);
        
        $message = "You have a new order with Order ID: " . $order['orderID'];
        $response = sendLineNotifyWithFile($message, $pdfFilePath);
        
        if ($response) {
            echo "PDF has been sent to LINE Notify!";
        } else {
            echo "Failed to send PDF to LINE.";
        }
    } else {
        echo "Order not found.";
    }
} else {
    echo "No order session found.";
}
?>