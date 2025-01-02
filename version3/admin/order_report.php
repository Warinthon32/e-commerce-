<?php include 'condb.php' ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Dashboard - SB Admin</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed">
    <?php include 'menu1.php' ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                  <br>
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            ข้อมูลการสั่งซื้อสินค้า
                        </div>
                        <div class="card-body">
                            <table id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>เลขที่ใบสั่งซื้อ</th>
                                        <th>ลูกค้า</th>
                                        <th>ที่อยู่</th>
                                        <th>เบอร์โทร</th>
                                        <th>ราคารวม</th>
                                        <th>วันที่สั่งซื้อ</th>
                                        <th>สถานะการสั่งซื้อ</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>orderID</th>
                                        <th>cus_name</th>
                                        <th>adds</th>
                                        <th>phone_number</th>
                                        <th>total_price</th>
                                        <th>order_status</th>
                                        <th>reg_date</th>
                                    </tr>
                                </tfoot>
                                <?php
                                $sql = "SELECT * FROM tb_order ORDER BY reg_date DESC";
                                $result = mysqli_query($conn, $sql);
                                ?>

                                <tbody>
                                <?php
                                while($row = mysqli_fetch_array($result)) {
                                $status = $row['order_status'];
                                ?>
                                    <tr>
                                        <td><?=$row['orderID']?></td>
                                        <td><?=$row['cus_name']?></td>
                                        <td><?=$row['adds']?></td>
                                        <td><?=$row['phone_number']?></td>
                                        <td><?=$row['total_price']?></td>
                                        <td><?=$row['reg_date']?></td>
                                        <td>
                                            <?php 
                                            if($status == 1){
                                                echo "ยังไม่ชำระเงิน";

                                            }else if($status == 2){
                                                echo "<b style ='color:green'>ชำระเงินแล้ว";
                                            }else if($status == 0){
                                                echo "<b style='color:red'>ยกเลิกการสั่งซื้อ";
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                <?php 
                                }
                                mysqli_close($conn);
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
          <?php include 'footer.php' ?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
        <script src="assets/demo/chart-area-demo.js"></script>
        <script src="assets/demo/chart-bar-demo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
        <script src="js/datatables-simple-demo.js"></script>
    </body>
</html> 
