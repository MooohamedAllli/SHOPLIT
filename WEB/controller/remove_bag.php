<?php
    $id = $_GET['id'];

    $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
    $stat = $pdo->exec("DELETE FROM orders_products_temp");

    header("location: ../products.php");
?>
