<?php 
    $pdo = new PDO('sqlite:../DB/SHOPLIT.db');
    $stat = $pdo->query("SELECT * ,strftime('%d-%m-%Y', order_date) AS Placed_AT FROM orders order by order_date desc");
    $orders = $stat->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/orders.css">
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

    <?php foreach($orders as $ord){ ?>

        <div class="Order">
            <div class="OrderCard">
                <table class="OrderTable">
                    <th style="width: 15%; color:grey;">Order Placed</th>
                    <th style="width: 10%; color:grey;">Total</th>
                    <th style="width: 40%; color:grey;">Shipped to</th>
                    <th style="width: 15%; color:grey;">Status</th>
                    <th style="width: 20%; color:grey;">Order #</th>
                    <tr>
                        <td><?= $ord['Placed_AT'];?></td>
                        <td><?= $ord['order_cost'];?></td>
                        <td><?= $ord['customer_add'];?>...</td>
                        <td><?= $ord['status'];?></td>
                        <td><?= $ord['id'];?></td>
                    </tr>
                </table>
                <table class="CustomerTable">
                    <tr>
                        <td style="width: 70%;">
                            <strong style="color:grey;">Customer Name:</strong> <?= $ord['customer_name'];?> <br>
                            <strong style="color:grey;">Customer Phone:</strong> <?= $ord['customer_phone'];?> <br>
                            <strong style="color:grey;">Customer Email:</strong> <?= $ord['customer_mail'];?>   
                        </td>
                        <td>
                            <button class="OrderButton">Order Details</button>
                            <button class="OrderButton">Cancel Order</button>
                        </td>
                    </tr>
                </table>
                <table class="DelivTable">
                    <tr>
                        <td>
                            <strong>Estimitad Delivery Time :</strong> 20230202
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    <?php }?>

    </body>
</html>