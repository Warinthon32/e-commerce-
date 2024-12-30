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
<div class="container text-center">
    <br></br>
<div class="row">
    <?php 
    $sql = "SELECT * FROM products ORDER BY pro_id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
    ?>
    <div class="col-sm-3">
    <div class="text-center product-card">
        <a href="product_detail.php?id=<?=$row['pro_id']?>">
            <img src="img/<?=$row['image']?>" width="200px" height="250px" class="mt-2 p-2 my-2 border"><br>
            ID: <?=$row['pro_id']?><br>
            <h5><?=$row['pro_name']?><br></h5>
            <h3 class="text-danger"><?=$row['price']?><br><h3>
        </a>
        <a class="btn btn-outline-primary" href="order.php?id=<?=$row['pro_id']?>">เพิ่มลงตะกร้า</a>
    </div>
    
    </div>
    <?php
    }
    mysqli_close($conn);
    ?> 
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
</div>
</body>
</html>