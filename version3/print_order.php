<?php
session_start();
include 'condb.php';

// ตรวจสอบว่ามี order_id ใน session หรือไม่
if (!isset($_SESSION["order_id"])) {
    die("Error: Missing order ID in session.");
}

$orderID = $_SESSION["order_id"];

// ดึงข้อมูลการสั่งซื้อ
$sql = "SELECT * FROM tb_order WHERE orderID='$orderID'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Error fetching order: " . mysqli_error($conn));
}

$rs = mysqli_fetch_array($result);

if (!$rs) {
    die("Error: Order not found.");
}

$total_price = $rs['total_price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print order</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container text-center">
  <div class="row">
    <div class="col-md-10">
    <div class="alert alert-primary h6 text-center mt-5 " role="alert"> การสั่งซื้อเสร็จสมบูรณ์</div>
    </div>
    <div class="col-md-10">
    เลขที่ใบสั่งซื้อ <?=$rs['orderID'] ?> <br>
    ชื่อชสกุล <?=$rs['cus_name'] ?> <br>
    ที่อยู่ <?=$rs['adds'] ?> <br>
    เบอร์โทรศัพท์ <?=$rs['phone_number'] ?> <br>
    <br>

    <table class="table">
  <thead>
    <tr>
      <th>รหัสสินค้า</th>
      <th>ชื่อสินค้า</th>
      <th>ราคา</th>
      <th>จำนวน</th>
      <th>ราคา</th>
    </tr>
  </thead>
  <tbody>

  <?php
  // ดึงข้อมูลรายละเอียดการสั่งซื้อ
  $sql1 = "SELECT * FROM order_detail d, products p WHERE d.pro_id=p.pro_id AND d.orderID='$orderID'";
  $result1 = mysqli_query($conn, $sql1);

  if (!$result1) {
      die("Error fetching order details: " . mysqli_error($conn));
  }

  while ($row = mysqli_fetch_array($result1)) {
  ?>
    <tr>
      <td><?=$row['pro_id']?></td>
      <td><?=$row['pro_name']?></td>
      <td><?=$row['order_price']?></td>
      <td><?=$row['orderQty']?></td>
      <td><?=$row['total']?></td>
    </tr>
  <?php
  }
  ?>
  </tbody>
</table>
    <h6>รวมเป็นเงิน <?= number_format($total_price, 2) ?> บาท </h6>
    </div>
  </div>
</div>
</body>
</html>