<?php include('condb.php') ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ร้านแป้งสวยถูกกว่าใคร</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<?php include 'menu.php' ?>
<div class="container">
    <br>
  <div class="row">

  <?php 
    $id = $_GET['pro_id'];
    $sql = "SELECT * FROM products,type WHERE products.type_id= Type.type_id    " ;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    ?>

    <div class="col-md-4 ">
        <div class="product-card">
        <img src="img/<?=$row['image']?>" width="400px"class="mt-2 p-2 my-2 border">
        </div>
    </div>
    
    <div class="col-md-6">
        <br>
        <div class="p-3 border rounded">

            <h3><?=$row['pro_name']?></h3>
             ID : <?=$row['pro_id']?>
            <p>ประเภท : <?=$row['type_name']?></p>
            <?=$row['detail']?><br><br>
            <h4 class="text-danger"><?=$row['price']?><small class="text-muted"> /ชิ้น</small></h4>
            <h4 class="text-danger"><?=$row['price_pack']?><small class="text-muted"> /แพ็ค</small></h4>
            <h4 class="text-danger"><?=$row['price_chest']?><small class="text-muted"> /ลัง</small></h4>
            <a class="btn btn-outline-primary" href="order.php?id=<?=$row['pro_id']?>">เพิ่มลงตะกร้า</a>
            
        
        </div>
    </div>

  </div>
</div>
<style>
    .product-card {
        transition: transform 0.2s;
    }
    .product-card:hover {
        transform: scale(1.05);
        border: 2px solid #000;
        border-radius: 10px;
    }
    .product-card a {
        text-decoration: none;
        color: inherit;
    }
</style>
<?php
    mysqli_close($conn);
?> 
</body>
</html>