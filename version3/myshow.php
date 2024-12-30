<?php include('condb.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แป้งสวย.com</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="logo">แป้งสวย</div>
        <div class="search-bar">
            <input type="text" placeholder="ค้นหาสินค้าถูกกว่าใครที่นี่">
        </div>
        <div class="actions">
            <a href="#">Login</a>
            <a href="#">Cart</a>
        </div>
    </header>

    <div class="container">
        <aside class="sidebar">
            <ul>
                <li>โลชั่น
                    <ul>
                        <li>โลชั่นบำรุงผิว</li>
                        <li>โลชั่นกันแดด</li>
                    </ul>
                </li>
                <li>ผลิตภัณฑ์ในครัวเรือน
                    <ul>
                        <li>น้ำยาล้างจาน</li>
                        <li>น้ำยาถูพื้น</li>
                    </ul>
                </li>
                <li>ผลิตภัณฑ์ทำความสะอาด
                    <ul>
                        <li>น้ำยาซักผ้า</li>
                        <li>น้ำยาล้างห้องน้ำ</li>
                    </ul>
                </li>
                <li>ขนมและอาหาร
                    <ul>
                        <li>ขนมขบเคี้ยว</li>
                        <li>อาหารแห้ง</li>
                    </ul>
                </li>
                <li>เครื่องสำอางและผลิตภัณฑ์เพื่อความงาม
                    <ul>
                        <li>ลิปสติก</li>
                        <li>แป้งพัฟ</li>
                    </ul>
                </li>
            </ul>
        </aside>

        <main class="main-content">
            <div class="featured">
                <h2>Featured Products</h2>
                <p>Check out our latest deals and offers!</p>
            </div>

            <div class="products">
                <?php 
                $sql = "SELECT * FROM products ORDER BY pro_id";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)){
                ?>
                <div class="product">
                    <img src="img/<?=$row['image']?>" width="100px" height="100px"><br>
                    ID: <?=$row['pro_id']?><br>
                    <?=$row['pro_name']?><br>
                    <?=$row['price']?><br>
                </div>
                <?php
                }
                mysqli_close($conn);
                ?> 
            </div>
        </main>
    </div>

    <footer>
        <p>&copy; 2024 Tmall. All Rights Reserved.</p>
    </footer>
</body>
</html>