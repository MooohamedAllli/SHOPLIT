<?php

if ($_SERVER['REQUEST_METHOD'] == "POST")
	{
        $cost = $_POST['shipping_cost'];

        $pdo = new PDO('sqlite:../../DB/SHOPLIT.db');
        $stat = $pdo->exec("UPDATE cost SET shipping_cost = ".$cost);

        header("location: ../settings.php");
    }
?>