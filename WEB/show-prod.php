<?php
    $URL_REF = $_SERVER['HTTP_REFERER'];

    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $id = $_GET['id'];
        $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
        $prod = $pdo->query("select * from products WHERE product_id =".$id)->fetchAll();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/show-prod.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Show Product</title>
</head>
<body>
    <div class="back">
        <a href="<?=$URL_REF;?>"><button class="btn btn-success" id="back">Back</button></a>
    </div>
    <br>
    <div class="details">
        <div class="image"><img src="<?=$prod[0]['image'];?>"></div>
        <div class="description">
            <table class="table table-hover">
                <th style="width:20%; text-align: center;">Data</th>
                <th style="text-align: center;">Value</th>
                <tr><td><strong>Product ID</strong></td><td><?=$prod[0]['product_id'];?></td></tr>
                <tr><td><strong>Reference ID</strong></td><td><?=$prod[0]['product_refferernce'];?></td></tr>
                <tr><td><strong>Shop</strong></td><td><?=$prod[0]['Shop'];?></td></tr>
                <tr><td><strong>Title</strong></td><td><?=$prod[0]['title'];?></td></tr>
                <tr><td><strong>Description</strong></td><td><?=$prod[0]['description'];?></td></tr>
                <tr><td><strong>URL</strong></td><td><a href="<?=$prod[0]['url'];?>"><?=$prod[0]['url'];?></a></td></tr>
                <tr><td><strong>Price Before</strong></td><td><?=$prod[0]['price_befor'];?></td></tr>
                <tr><td><strong>Price After</strong></td><td><?=$prod[0]['price_after'];?></td></tr>
                <tr><td><strong>Discount</strong></td><td><?=$prod[0]['discount'];?></td></tr>
                <tr><td><strong>Actual Product Cost</strong></td><td><?=$prod[0]['actual_product_cost'];?></td></tr>
                <tr><td><strong>Shipping Cost</strong></td><td><?=$prod[0]['shipping_cost'];?></td></tr>
                <tr><td><strong>Selling Price</strong></td><td><?=$prod[0]['selling_price'];?></td></tr>
                <tr><td><strong>Profit</strong></td><td><?=$prod[0]['profit'];?></td></tr>
            </table>
        </div>
    </div>
</body>
</html>