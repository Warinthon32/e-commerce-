<?php 
session_start();
include 'condb.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ตะกร้าสินค้า</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include 'menu.php' ?>
<br>
    <div class="container">
        <form id="form1" action="insert_cart.php" method="post">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="alert alert-primary h6 text-center" role="alert"> รายการสั่งซื้อสินค้า</div>
                <div class="card p-3" style="border-radius: 15px;">
                    <table class="table table-hover">
                        <tr>
                            <th>ลำดับที่</th>
                            <th>ชื่อสินค้า</th>
                            <th>ราคา</th>
                            <th>จำนวนสินค้า</th>
                            <th>ราคารวม</th>
                            <th>เพิ่ม-ลด</th>
                            <th>ลบ</th>
                        </tr>
                        <?php
                            $total = 0;
                            $sumPrice = 0;
                            $m = 1;
                            for($i = 0; $i <= (int)$_SESSION["intLine"]; $i++){
                                if($_SESSION["strProductID"][$i] != ""){
                                    $sql1 = "SELECT * FROM products WHERE pro_id = '".$_SESSION["strProductID"][$i]."' ";
                                    $result1 = mysqli_query($conn, $sql1);
                                    $row_pro = mysqli_fetch_array($result1);
                                    
                                    $price = $row_pro['price'];
                                    $price_pack = $row_pro['price_pack'];
                                    $price_chest = $row_pro['price_chest'];
                                    $selectedPrice = isset($_POST['price'][$i]) ? $_POST['price'][$i] : $price;
                                    $total = $_SESSION["strQty"][$i];
                                    $sum = $total * $selectedPrice;
                                    $sumPrice += $sum;
                                    $sumPriceFormatted = number_format($sumPrice);
                                    $_SESSION["sum_price"] = $sumPriceFormatted;
                        ?>
                        <tr>
                            <td><?=$m?></td>
                            <td>
                                <img src="img/<?=$row_pro['image'];?>" width="80px" height="100px" class="border" onerror="this.onerror=null; this.src='img/default.png';">
                                <?=$row_pro['pro_name'];?>
                            </td>
                            <td>
                                <select name="price[<?=$i?>]" form="form1" onchange="this.form.submit()">
                                    <option value="<?=$price?>" <?=($selectedPrice == $price) ? 'selected' : ''?>><?=$price?></option>
                                    <option value="<?=$price_pack?>" <?=($selectedPrice == $price_pack) ? 'selected' : ''?>><?=$price_pack?></option>
                                    <option value="<?=$price_chest?>" <?=($selectedPrice == $price_chest) ? 'selected' : ''?>><?=$price_chest?></option>
                                </select>
                            </td>
                            <td><?=$_SESSION["strQty"][$i]?></td>
                            <td><?=$sumPriceFormatted?></td>
                            <td> 
                                <a href="order.php?id=<?=$row_pro['pro_id'];?>&action=add" class="btn btn-outline-primary">+</a>
                                <?php if($_SESSION["strQty"][$i] >1){ ?>
                                <a href="orderdel.php?id=<?=$row_pro['pro_id'];?>&action=remove" class="btn btn-outline-primary">-</a>
                                <?php } ?>
                            </td>
                            <td><a href="pro_delete.php?Line=<?=$i?>" style="color:red; font-weight:bold; text-decoration:none;">นำออก</a></td>
                        </tr>
                        <?php
                                $m++;
                                }
                            }
                        ?>
                        <tr>
                            <td class="text-end" colspan="5">รวมเป็นเงิน</td>
                            <td class="text-center"><?=$sumPriceFormatted?></td>
                            <td>บาท</td>
                        </tr>
                    </table>
                    <div style="text-align:right">
                        <a href="show_product.php"><button type="button" class="btn btn-outline-secondary">เลือกสินค้าอื่นต่อ</button></a> |
                        <button type="submit" class="btn btn-outline-success">ยืนยันการสั่งซื้อ</button>
                    </div>
                </div>
            </div>
        </div>
        <br><br>
        <div class="row justify-content-center">
            <div class="col-md-6">
            <div class="alert alert-success text-center" role="alert">ข้อมูลจัดส่งสินค้า</div>
            <div class="card p-3" style="border-radius: 15px;">
                <div class="mb-3">
                <label for="cus_name" class="form-label">ชื่อ-นามสกุล:</label>
                <input type="text" name="cus_name" class="form-control" required placeholder="กรอกชื่อ">
                </div>
                <div class="mb-3">
                <label for="cus_adds" class="form-label">ที่อยู่:</label>
                <textarea class="form-control" required placeholder="กรอกที่อยู่" name="cus_adds" rows="3"></textarea>
                </div>
                <div class="mb-3">
                <label for="cus_tel" class="form-label">เบอร์โทรศัพท์:</label>
                <input type="number" name="cus_tel" class="form-control" required placeholder="เบอร์โทรศัพท์">
                </div>
            </div>
            <br><br>
            </div>
        </div>
        </form>
    </div>
</body>
</html>