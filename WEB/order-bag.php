<?php
include('constants.php');

$URL_REF = $_SERVER['HTTP_REFERER'];
$counter = 0;

$pdo = new PDO('sqlite:../DB/SHOPLIT.db');
$order_details = $pdo->query("with prods as (SELECT * FROM orders_products_temp) select * from prods A left join products b on a.product_id = b.product_id")->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Bag</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/order-bag.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
</head>
<body>
    <div class="header">
        <div class="logout">
            <form action="login.php">
                <input type="submit" value="Logout">
            </form>
            <form action="admin-home.php">
                <input type="submit" value="Home">
            </form>
        </div>
        <div class="logo"><img src="img/logo.png" width="60px" height="60px"></div>
    </div>  

    <br>
    <div class="back">
        <form action="controller/remove_bag.php">
            <button class="btn btn-danger" >Clear Bag</button>
        </form>
    </div>
    <br>
    
    <form action="controller/confirm_order.php" method="POST" id="myform">  
        <table class="table table-hover">
            <tr><th>Order Details</th></tr>
            <tr>
                <th style="width: 10%">product id</th>
                <th style="width: 10%">Shop</th>
                <th style="width: 10%">Price</th>
                <th style="width: 10%">Name</th>
                <th style="width: 10%">URL</th>
                <th style="width: 10%">Image</th>
                <th style="width: 10%">Quantity</th>
                <th style="width: 10%">Remove</th>
            </tr>

            <?php foreach ($order_details as $ord){ 
                $counter = $counter+1; ?>    
                <tr>
                    <td><input type="hidden" value="<?=$ord['product_id'];?>" name="product_id.<?=$counter;?>"><?=$ord['product_id'];?></td>
                    <td><input type="hidden" value="<?=$ord['Shop'];?>" name="Shop.<?=$counter;?>"><?=$ord['Shop'];?></td>
                    <td><input type="hidden" value="<?=$ord['selling_price'];?>" name="selling_price.<?=$counter;?>"><?=$ord['selling_price'];?></td>
                    <td><input type="hidden" value="<?=$ord['title'];?>" name="title.<?=$counter;?>"><?=$ord['title'];?></td>
                    <td><input type="hidden" value="<?=$ord['url'];?>" name="url.<?=$counter;?>"><?=$ord['url'];?></td>
                    <td><img src="<?=$ord['image'];?>" style="width: 30px; height: 30px;"></td>
                    <td><input type="text" placeholder="Quantity" name = "quantity.<?=$counter;?>" value="1"></td>
                    <form action="login.php" action="get" style="display:none;"></form>
                    <td>
                        <a href="<?=$BASE_URL;?>/controller/remove_bag_item.php?id=<?=$ord['order_id'];?>">
                            Delete
                        </a>
                    </td>
                    <?php };?>
                </tr>
        </table>    

        <div class="customer_info">
            <table class="table table-hover">
                <tr><th>Customer Details</th></tr>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Customer Email</th>
                    <th>Customer Address</th>
                </tr>
                <tr>
                    <td><input type="text" placeholder="Name" name = "Name"></td>
                    <td><input type="text" placeholder="Phone" name = "Phone"></td>
                    <td><input type="text" placeholder="Email" name = "Email"></td>
                    <td><input type="text" placeholder="Address" name = "Address"></td>
                </tr>
            </table>
        </div>

        <button class="btn btn-success" type="submit" form="myform">Confirm Order</button>
    </form>
    <br>
    
</body>
</html>