<?php
    $id = $_GET['id'];

    $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
    $stat = $pdo->exec("DELETE FROM orders_products_temp WHERE order_id = ".$id);

    header("location: ../order-bag.php");
?>
