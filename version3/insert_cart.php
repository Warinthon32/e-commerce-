<?php
session_start();
include 'condb.php';

// ตรวจสอบการเชื่อมต่อฐานข้อมูล
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$cusName = $_POST['cus_name'];
$cusAddress = $_POST['cus_adds'];
$cusTel = $_POST['cus_tel'];

// กำหนดค่าให้กับ $_SESSION["sum_price"]
$sumPriceFormatted = $_SESSION["sum_price"];

// ตรวจสอบค่าตัวแปรก่อนใช้ในคำสั่ง SQL
if (empty($cusName) || empty($cusAddress) || empty($cusTel) || empty($sumPriceFormatted)) {
    die("Error: Missing required fields");
}

// กำหนดค่า reg_date เป็นวันที่ปัจจุบัน
$regDate = date('Y-m-d H:i:s');

$sql = "INSERT INTO tb_order(cus_name, adds, phone_number, total_price, order_status, reg_date) 
        VALUES ('$cusName', '$cusAddress', '$cusTel', '$sumPriceFormatted', '1', '$regDate')";

if (!mysqli_query($conn, $sql)) {
    die("Error inserting order: " . mysqli_error($conn));
}

$orderID = mysqli_insert_id($conn);
$_SESSION["order_id"] = $orderID; // ตั้งค่า order_id ใน session

for ($i = 0; $i <= (int)$_SESSION["intLine"]; $i++) {
    if ($_SESSION["strProductID"][$i] != "") {
        // ดึงข้อมูลสินค้า
        $sql1 = "SELECT * FROM products WHERE pro_id = '".$_SESSION["strProductID"][$i]."'";
        $result1 = mysqli_query($conn, $sql1);
        if (!$result1) {
            die("Error fetching product details: " . mysqli_error($conn));
        }
        $row1 = mysqli_fetch_array($result1);
        $price = $row1["price"];
        $total = $_SESSION["strQty"][$i] * $price;

        $sql2 = "INSERT INTO order_detail(orderID, pro_id, order_price, orderQty, total)
                 VALUES ('$orderID', '".$_SESSION["strProductID"][$i]."', '$price', '".$_SESSION["strQty"][$i]."', '$total')";

        if (!mysqli_query($conn, $sql2)) {
            die("Error inserting order details: " . mysqli_error($conn));
        }

        // ตัดสต๊อก
        $sql3 = "UPDATE products SET amount = amount - '".$_SESSION["strQty"][$i]."' WHERE pro_id = '".$_SESSION["strProductID"][$i]."'";

        if (!mysqli_query($conn, $sql3)) {
            die("Error updating product stock: " . mysqli_error($conn));
        }
    }
}

mysqli_close($conn);

// ลบข้อมูลที่ไม่ต้องการใน session แทนการทำลาย session ทั้งหมด
unset($_SESSION["intLine"]);
unset($_SESSION["strProductID"]);
unset($_SESSION["strQty"]);
unset($_SESSION["sum_price"]);

echo "<script>alert('บันทึกข้อมูลเรียบร้อยแล้ว'); window.location='print_order.php';</script>";

?>